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
use inklabs\kommerce\Lib\UuidInterface;

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
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);
        $product = $this->dummyData->getProduct();
        $this->entityManager->persist($warehouse);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->executeRepositoryCRUD(
            $this->inventoryTransactionRepository,
            $this->dummyData->getInventoryTransaction($inventoryLocation, $product)
        );
    }

    public function testFindOneById()
    {
        $originalInventoryTransaction = $this->setupInventoryTransaction();
        $this->entityManager->persist($originalInventoryTransaction);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $this->setCountLogger();

        $inventoryTransaction = $this->inventoryTransactionRepository->findOneById(
            $originalInventoryTransaction->getId()
        );

        $this->assertEquals($originalInventoryTransaction->getId(), $inventoryTransaction->getId());
        $this->assertTrue($inventoryTransaction->getProduct() instanceof Product);
        $this->assertTrue($inventoryTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertSame('Initial Inventory', $inventoryTransaction->getMemo());
        $this->assertSame(null, $inventoryTransaction->getDebitQuantity());
        $this->assertSame(2, $inventoryTransaction->getCreditQuantity());
        $this->assertTrue($inventoryTransaction->getType()->isMove());
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsNotFoundException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'InventoryTransaction not found'
        );

        $this->inventoryTransactionRepository->findOneById(
            $this->dummyData->getId()
        );
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

        $inventoryLocationId = $this->inventoryTransactionRepository->findInventoryIdForProductAndQuantity(
            $product,
            2
        );

        $this->assertTrue($inventoryLocationId instanceof UuidInterface);
    }

    public function testFindInventoryIdForProductAndQuantityThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'InventoryTransaction not found'
        );

        $product = $this->dummyData->getProduct();
        $this->inventoryTransactionRepository->findInventoryIdForProductAndQuantity($product, 2);
    }

    private function setupProductWith2InventoryTransactions()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);
        $product = $this->dummyData->getProduct();

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
}
