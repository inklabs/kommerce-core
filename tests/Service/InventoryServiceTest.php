<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityRepository\InventoryLocationRepository;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepository;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\Exception\InsufficientInventoryException;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeInventoryLocationRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeInventoryTransactionRepository;

class InventoryServiceTest extends ServiceTestCase
{
    /** @var InventoryLocationRepositoryInterface */
    protected $inventoryLocationRepository;

    /** @var InventoryTransactionRepositoryInterface */
    protected $inventoryTransactionRepository;

    /** @var InventoryServiceInterface */
    protected $inventoryService;

    protected $metaDataClassNames = [
        InventoryLocation::class,
        InventoryTransaction::class,
        Product::class,
        Warehouse::class,
    ];

    /** @var Warehouse */
    private $warehouse;

    public function setUp()
    {
        parent::setUp();

        $this->inventoryLocationRepository = $this->getRepositoryFactory()->getInventoryLocationRepository();
        $this->inventoryTransactionRepository = $this->getRepositoryFactory()->getInventoryTransactionRepository();

        $this->inventoryService = new InventoryService(
            $this->inventoryLocationRepository,
            $this->inventoryTransactionRepository
        );

        $this->initializeWarehouse();
    }

    private function initializeWarehouse()
    {
        $this->warehouse = $this->dummyData->getWarehouse();
        $this->entityManager->persist($this->warehouse);
        $this->entityManager->flush();
    }

    public function testReserveProduct()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation($this->warehouse);
        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->entityManager->persist($product);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($initialTransaction);
        $this->entityManager->flush();

        $this->inventoryService->reserveProduct($product, 2);

        $transactions = $this->inventoryTransactionRepository->findAllByProduct($product);
        $debitTransaction = $transactions[1];
        $creditTransaction = $transactions[2];

        $this->assertTrue($debitTransaction->getType()->isHold());
        $this->assertSame(-2, $debitTransaction->getQuantity());
        $this->assertSame('Hold items for order', $debitTransaction->getMemo());

        $this->assertTrue($creditTransaction->getType()->isHold());
        $this->assertSame(2, $creditTransaction->getQuantity());
        $this->assertSame('Hold items for order', $creditTransaction->getMemo());
    }

    public function testReserveProductDoesNothingForProductsWithoutInventoryRequired()
    {
        $product = $this->dummyData->getProduct();
        $product->setIsInventoryRequired(false);

        $this->inventoryService->reserveProduct($product, 2);
    }

    public function testReserveProductThrowsExceptionIfInsufficientInventory()
    {
        $product = $this->dummyData->getProduct();

        $this->setExpectedException(
            InsufficientInventoryException::class,
            'Insufficient Inventory'
        );

        $this->inventoryService->reserveProduct($product, 2);
    }

    public function testMoveProductBetweenLocations()
    {
        $product = $this->dummyData->getProduct();
        $sourceLocation = $this->dummyData->getInventoryLocation($this->warehouse);
        $destinationLocation = $this->dummyData->getInventoryLocation($this->warehouse);
        $initialTransaction = $this->dummyData->getInventoryTransaction($sourceLocation, $product);
        $this->entityManager->persist($product);
        $this->entityManager->persist($sourceLocation);
        $this->entityManager->persist($destinationLocation);
        $this->entityManager->persist($initialTransaction);
        $this->entityManager->flush();

        $this->inventoryService->moveProduct($product, 2, $sourceLocation->getId(), $destinationLocation->getId());

        $transactions = $this->inventoryTransactionRepository->findAllByProduct($product);
        $debitTransaction = $transactions[1];
        $creditTransaction = $transactions[2];

        $this->assertTrue($debitTransaction->getType()->isMove());
        $this->assertSame(-2, $debitTransaction->getQuantity());
        $this->assertSame('Move items', $debitTransaction->getMemo());

        $this->assertTrue($creditTransaction->getType()->isMove());
        $this->assertSame(2, $creditTransaction->getQuantity());
        $this->assertSame('Move items', $creditTransaction->getMemo());
    }

    public function testAddProduct()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation($this->warehouse);
        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->entityManager->persist($product);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($initialTransaction);
        $this->entityManager->flush();

        $this->inventoryService->addProduct(
            $product,
            3,
            $inventoryLocation->getId()
        );

        $transactions = $this->inventoryTransactionRepository->findAllByProduct($product);
        $debitTransaction = $transactions[1];
        $creditTransaction = $transactions[2];

        $this->assertSame(null, $debitTransaction->getInventoryLocation());
        $this->assertTrue($debitTransaction->getType()->isNewProducts());
        $this->assertSame(-3, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: New Products', $debitTransaction->getMemo());

        $this->assertTrue($creditTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($creditTransaction->getType()->isNewProducts());
        $this->assertSame(3, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: New Products', $creditTransaction->getMemo());
    }

    public function testShipProduct()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation($this->warehouse);
        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->entityManager->persist($product);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($initialTransaction);
        $this->entityManager->flush();

        $this->inventoryService->shipProduct(
            $product,
            1,
            $inventoryLocation->getId()
        );

        $transactions = $this->inventoryTransactionRepository->findAllByProduct($product);
        $debitTransaction = $transactions[1];
        $creditTransaction = $transactions[2];

        $this->assertTrue($debitTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($debitTransaction->getType()->isShipped());
        $this->assertSame(-1, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Shipped', $debitTransaction->getMemo());

        $this->assertSame(null, $creditTransaction->getInventoryLocation());
        $this->assertTrue($creditTransaction->getType()->isShipped());
        $this->assertSame(1, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Shipped', $creditTransaction->getMemo());
    }

    public function testReturnProduct()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation($this->warehouse);
        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->entityManager->persist($product);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($initialTransaction);
        $this->entityManager->flush();

        $this->inventoryService->returnProduct(
            $product,
            1,
            $inventoryLocation->getId()
        );

        $transactions = $this->inventoryTransactionRepository->findAllByProduct($product);
        $debitTransaction = $transactions[1];
        $creditTransaction = $transactions[2];

        $this->assertSame(null, $debitTransaction->getInventoryLocation());
        $this->assertTrue($debitTransaction->getType()->isReturned());
        $this->assertSame(-1, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Returned', $debitTransaction->getMemo());

        $this->assertTrue($creditTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($creditTransaction->getType()->isReturned());
        $this->assertSame(1, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Returned', $creditTransaction->getMemo());
    }

    public function testReduceProductForPromotion()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation($this->warehouse);
        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->entityManager->persist($product);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($initialTransaction);
        $this->entityManager->flush();

        $this->inventoryService->reduceProductForPromotion(
            $product,
            1,
            $inventoryLocation->getId()
        );

        $transactions = $this->inventoryTransactionRepository->findAllByProduct($product);
        $debitTransaction = $transactions[1];
        $creditTransaction = $transactions[2];

        $this->assertTrue($debitTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($debitTransaction->getType()->isPromotion());
        $this->assertSame(-1, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Promotion', $debitTransaction->getMemo());

        $this->assertSame(null, $creditTransaction->getInventoryLocation());
        $this->assertTrue($creditTransaction->getType()->isPromotion());
        $this->assertSame(1, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Promotion', $creditTransaction->getMemo());
    }

    public function testReduceProductForDamage()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation($this->warehouse);
        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->entityManager->persist($product);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($initialTransaction);
        $this->entityManager->flush();

        $this->inventoryService->reduceProductForDamage(
            $product,
            1,
            $inventoryLocation->getId()
        );

        $transactions = $this->inventoryTransactionRepository->findAllByProduct($product);
        $debitTransaction = $transactions[1];
        $creditTransaction = $transactions[2];

        $this->assertTrue($debitTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($debitTransaction->getType()->isDamaged());
        $this->assertSame(-1, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Damaged', $debitTransaction->getMemo());

        $this->assertSame(null, $creditTransaction->getInventoryLocation());
        $this->assertTrue($creditTransaction->getType()->isDamaged());
        $this->assertSame(1, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Damaged', $creditTransaction->getMemo());
    }

    public function testReduceProductForShrinkage()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation($this->warehouse);
        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->entityManager->persist($product);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($initialTransaction);
        $this->entityManager->flush();

        $this->inventoryService->reduceProductForShrinkage(
            $product,
            1,
            $inventoryLocation->getId()
        );

        $transactions = $this->inventoryTransactionRepository->findAllByProduct($product);
        $debitTransaction = $transactions[1];
        $creditTransaction = $transactions[2];

        $this->assertTrue($debitTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($debitTransaction->getType()->isShrinkage());
        $this->assertSame(-1, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Shrinkage', $debitTransaction->getMemo());

        $this->assertSame(null, $creditTransaction->getInventoryLocation());
        $this->assertTrue($creditTransaction->getType()->isShrinkage());
        $this->assertSame(1, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Shrinkage', $creditTransaction->getMemo());
    }
}
