<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeInventoryLocationRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeInventoryTransactionRepository;

class InventoryServiceTest extends DoctrineTestCase
{
    /** @var FakeInventoryLocationRepository */
    protected $fakeInventoryLocationRepository;

    /** @var FakeInventoryTransactionRepository */
    protected $fakeInventoryTransactionRepository;

    /** @var InventoryServiceInterface */
    protected $inventoryService;

    public function setUp()
    {
        parent::setUp();

        $this->fakeInventoryLocationRepository = new FakeInventoryLocationRepository;
        $this->fakeInventoryTransactionRepository = new FakeInventoryTransactionRepository;

        $this->inventoryService = new InventoryService(
            $this->fakeInventoryLocationRepository,
            $this->fakeInventoryTransactionRepository
        );
    }

    public function testReserveProduct()
    {
        $product = $this->dummyData->getProduct();
        $location = $this->dummyData->getInventoryLocation();
        $this->fakeInventoryLocationRepository->create($location);

        $initialTransaction = $this->dummyData->getInventoryTransaction($location, $product);
        $this->fakeInventoryTransactionRepository->create($initialTransaction);

        $this->inventoryService->reserveProduct($product, 2);

        $debitTransaction = $this->fakeInventoryTransactionRepository->findOneById(2);
        $this->assertTrue($debitTransaction->getType()->isHold());
        $this->assertSame(-2, $debitTransaction->getQuantity());
        $this->assertSame('Hold items for order', $debitTransaction->getMemo());

        $creditTransaction = $this->fakeInventoryTransactionRepository->findOneById(3);
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

        $sourceLocation = $this->dummyData->getInventoryLocation();
        $destinationLocation = $this->dummyData->getInventoryLocation();
        $this->fakeInventoryLocationRepository->create($sourceLocation);
        $this->fakeInventoryLocationRepository->create($destinationLocation);

        $initialTransaction = $this->dummyData->getInventoryTransaction($sourceLocation, $product);
        $this->fakeInventoryTransactionRepository->create($initialTransaction);

        $this->inventoryService->moveProduct($product, 2, $sourceLocation->getId(), $destinationLocation->getId());

        $debitTransaction = $this->fakeInventoryTransactionRepository->findOneById(2);
        $this->assertTrue($debitTransaction->getType()->isMove());
        $this->assertSame(-2, $debitTransaction->getQuantity());
        $this->assertSame('Move items', $debitTransaction->getMemo());

        $creditTransaction = $this->fakeInventoryTransactionRepository->findOneById(3);
        $this->assertTrue($creditTransaction->getType()->isMove());
        $this->assertSame(2, $creditTransaction->getQuantity());
        $this->assertSame('Move items', $creditTransaction->getMemo());
    }

    public function testAddProduct()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation();
        $this->fakeInventoryLocationRepository->create($inventoryLocation);

        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->fakeInventoryTransactionRepository->create($initialTransaction);

        $this->inventoryService->addProduct(
            $product,
            3,
            $inventoryLocation->getId()
        );

        $debitTransaction = $this->fakeInventoryTransactionRepository->findOneById(2);
        $this->assertSame(null, $debitTransaction->getInventoryLocation());
        $this->assertTrue($debitTransaction->getType()->isNewProducts());
        $this->assertSame(-3, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: New Products', $debitTransaction->getMemo());

        $creditTransaction = $this->fakeInventoryTransactionRepository->findOneById(3);
        $this->assertTrue($creditTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($creditTransaction->getType()->isNewProducts());
        $this->assertSame(3, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: New Products', $creditTransaction->getMemo());
    }

    public function testShipProduct()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation();
        $this->fakeInventoryLocationRepository->create($inventoryLocation);

        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->fakeInventoryTransactionRepository->create($initialTransaction);

        $this->inventoryService->shipProduct(
            $product,
            1,
            $inventoryLocation->getId()
        );

        $debitTransaction = $this->fakeInventoryTransactionRepository->findOneById(2);
        $this->assertTrue($debitTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($debitTransaction->getType()->isShipped());
        $this->assertSame(-1, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Shipped', $debitTransaction->getMemo());

        $creditTransaction = $this->fakeInventoryTransactionRepository->findOneById(3);
        $this->assertSame(null, $creditTransaction->getInventoryLocation());
        $this->assertTrue($creditTransaction->getType()->isShipped());
        $this->assertSame(1, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Shipped', $creditTransaction->getMemo());
    }

    public function testReturnProduct()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation();
        $this->fakeInventoryLocationRepository->create($inventoryLocation);

        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->fakeInventoryTransactionRepository->create($initialTransaction);

        $this->inventoryService->returnProduct(
            $product,
            1,
            $inventoryLocation->getId()
        );

        $debitTransaction = $this->fakeInventoryTransactionRepository->findOneById(2);
        $this->assertSame(null, $debitTransaction->getInventoryLocation());
        $this->assertTrue($debitTransaction->getType()->isReturned());
        $this->assertSame(-1, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Returned', $debitTransaction->getMemo());

        $creditTransaction = $this->fakeInventoryTransactionRepository->findOneById(3);
        $this->assertTrue($creditTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($creditTransaction->getType()->isReturned());
        $this->assertSame(1, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Returned', $creditTransaction->getMemo());
    }

    public function testReduceProductForPromotion()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation();
        $this->fakeInventoryLocationRepository->create($inventoryLocation);

        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->fakeInventoryTransactionRepository->create($initialTransaction);

        $this->inventoryService->reduceProductForPromotion(
            $product,
            1,
            $inventoryLocation->getId()
        );

        $debitTransaction = $this->fakeInventoryTransactionRepository->findOneById(2);
        $this->assertTrue($debitTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($debitTransaction->getType()->isPromotion());
        $this->assertSame(-1, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Promotion', $debitTransaction->getMemo());

        $creditTransaction = $this->fakeInventoryTransactionRepository->findOneById(3);
        $this->assertSame(null, $creditTransaction->getInventoryLocation());
        $this->assertTrue($creditTransaction->getType()->isPromotion());
        $this->assertSame(1, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Promotion', $creditTransaction->getMemo());
    }

    public function testReduceProductForDamage()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation();
        $this->fakeInventoryLocationRepository->create($inventoryLocation);

        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->fakeInventoryTransactionRepository->create($initialTransaction);

        $this->inventoryService->reduceProductForDamage(
            $product,
            1,
            $inventoryLocation->getId()
        );

        $debitTransaction = $this->fakeInventoryTransactionRepository->findOneById(2);
        $this->assertTrue($debitTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($debitTransaction->getType()->isDamaged());
        $this->assertSame(-1, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Damaged', $debitTransaction->getMemo());

        $creditTransaction = $this->fakeInventoryTransactionRepository->findOneById(3);
        $this->assertSame(null, $creditTransaction->getInventoryLocation());
        $this->assertTrue($creditTransaction->getType()->isDamaged());
        $this->assertSame(1, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Damaged', $creditTransaction->getMemo());
    }

    public function testReduceProductForShrinkage()
    {
        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation();
        $this->fakeInventoryLocationRepository->create($inventoryLocation);

        $initialTransaction = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $this->fakeInventoryTransactionRepository->create($initialTransaction);

        $this->inventoryService->reduceProductForShrinkage(
            $product,
            1,
            $inventoryLocation->getId()
        );

        $debitTransaction = $this->fakeInventoryTransactionRepository->findOneById(2);
        $this->assertTrue($debitTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($debitTransaction->getType()->isShrinkage());
        $this->assertSame(-1, $debitTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Shrinkage', $debitTransaction->getMemo());

        $creditTransaction = $this->fakeInventoryTransactionRepository->findOneById(3);
        $this->assertSame(null, $creditTransaction->getInventoryLocation());
        $this->assertTrue($creditTransaction->getType()->isShrinkage());
        $this->assertSame(1, $creditTransaction->getQuantity());
        $this->assertSame('Adjusting inventory: Shrinkage', $creditTransaction->getMemo());
    }
}
