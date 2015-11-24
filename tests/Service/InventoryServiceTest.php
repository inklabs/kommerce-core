<?php
namespace inklabs\kommerce\Service;

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
        $creditTransaction = $this->fakeInventoryTransactionRepository->findOneById(3);
        $this->assertSame(-2, $debitTransaction->getQuantity());
        $this->assertSame(2, $creditTransaction->getQuantity());
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
}
