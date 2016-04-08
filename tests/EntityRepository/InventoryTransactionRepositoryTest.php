<?php
namespace inklabs\kommerce\tests\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class InventoryTransactionRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        InventoryLocation::class,
        InventoryTransaction::class,
        Product::class,
        Warehouse::class,
    ];

    /** @var InventoryTransactionRepositoryInterface */
    protected $inventoryTransactionRepository;

    public function setUp()
    {
        parent::setUp();
        $this->inventoryTransactionRepository = $this->getRepositoryFactory()->getInventoryTransactionRepository();
    }

    private function setupInventoryTransaction()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);
        $product = $this->dummyData->getProduct();

        $this->entityManager->persist($warehouse);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $inventoryTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        return $inventoryTransaction;
    }

    public function testCRUD()
    {
        $inventoryTransaction = $this->setupInventoryTransaction();

        $this->inventoryTransactionRepository->create($inventoryTransaction);
        $this->assertSame(1, $inventoryTransaction->getId());

        $inventoryTransaction->setMemo('Modified Memo');
        $this->assertSame(null, $inventoryTransaction->getUpdated());
        $this->inventoryTransactionRepository->update($inventoryTransaction);
        $this->assertTrue($inventoryTransaction->getUpdated() instanceof DateTime);

        $this->inventoryTransactionRepository->delete($inventoryTransaction);
        $this->assertSame(null, $inventoryTransaction->getId());
    }

    public function testFindOneById()
    {
        $inventoryTransaction = $this->setupInventoryTransaction();
        $this->entityManager->persist($inventoryTransaction);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $this->setCountLogger();

        $inventoryTransaction = $this->inventoryTransactionRepository->findOneById(1);

        $this->assertSame(1, $this->getTotalQueries());
        $this->assertTrue($inventoryTransaction instanceof InventoryTransaction);
        $this->assertTrue($inventoryTransaction->getProduct() instanceof Product);
        $this->assertTrue($inventoryTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertSame('Initial Inventory', $inventoryTransaction->getMemo());
        $this->assertSame(null, $inventoryTransaction->getDebitQuantity());
        $this->assertSame(2, $inventoryTransaction->getCreditQuantity());
        $this->assertTrue($inventoryTransaction->getType()->isMove());
    }

    public function testFindOneByIdThrowsNotFoundException()
    {
        $this->setExpectedException(
            \inklabs\kommerce\Exception\EntityNotFoundException::class,
            'InventoryTransaction not found'
        );

        $this->inventoryTransactionRepository->findOneById(1);
    }

    public function testFindAllByProduct()
    {
        $product = $this->setupProductWith2InventoryTransactions();

        $inventoryTransactions = $this->inventoryTransactionRepository->findAllByProduct($product);

        $this->assertSame(2, count($inventoryTransactions));
        $this->assertTrue($inventoryTransactions[0] instanceof InventoryTransaction);
    }

    public function testFindInventoryIdForProductAndQuantity()
    {
        $product = $this->setupProductWith2InventoryTransactions();

        $inventoryId = $this->inventoryTransactionRepository->findInventoryIdForProductAndQuantity($product, 2);

        $this->assertSame(1, $inventoryId);
    }

    /**
     * @return Product
     */
    protected function setupProductWith2InventoryTransactions()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);
        $product = $this->dummyData->getProduct(1);

        $inventoryTransaction1 = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $inventoryTransaction2 = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);

        $this->entityManager->persist($warehouse);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($product);
        $this->entityManager->persist($inventoryTransaction1);
        $this->entityManager->persist($inventoryTransaction2);
        $this->entityManager->flush();
        $this->entityManager->clear();
        return $product;
    }

    public function testFindInventoryIdForProductAndQuantityThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'InventoryTransaction not found'
        );

        $this->inventoryTransactionRepository->findInventoryIdForProductAndQuantity(new Product, 2);
    }
}
