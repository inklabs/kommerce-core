<?php
namespace inklabs\kommerce\Action\Order\Handler;

use inklabs\kommerce\Action\Inventory\AdjustInventoryCommand;
use inklabs\kommerce\Action\Inventory\Handler\AdjustInventoryHandler;
use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Service\InventoryServiceInterface;
use inklabs\kommerce\Service\ProductServiceInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class AdjustInventoryHandlerTest extends DoctrineTestCase
{
    /** @var AdjustInventoryHandler */
    protected $handler;

    /**
     * @return array
     */
    public function setUp()
    {
        parent::setUp();

        $productService = $this->getMockeryMock(ProductServiceInterface::class);
        $productService->shouldReceive('findOneById')
            ->once()
            ->andReturn(new Product);
        /** @var ProductServiceInterface $productService */

        $inventoryService = $this->getMockeryMock(InventoryServiceInterface::class);
        $inventoryService->shouldReceive('adjustInventory')
            ->once();
        /** @var InventoryServiceInterface $inventoryService */

        $this->handler = new AdjustInventoryHandler($inventoryService, $productService);
    }

    public function testHandle()
    {
        $command = new AdjustInventoryCommand(
            1,
            3,
            1,
            InventoryTransactionType::SHIPPED
        );

        $this->handler->handle($command);
    }
}
