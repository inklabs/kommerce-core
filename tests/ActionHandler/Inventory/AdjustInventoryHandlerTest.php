<?php
namespace inklabs\kommerce\ActionHandler\Inventory;

use inklabs\kommerce\Action\Inventory\AdjustInventoryCommand;
use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AdjustInventoryHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $productService = $this->mockService->getProductService();
        $inventoryService = $this->mockService->getInventoryService();
        $inventoryService->shouldReceive('adjustInventory')
            ->once();

        $productId = 1;
        $quantity = 3;
        $inventoryLocationId = 1;
        $command = new AdjustInventoryCommand(
            $productId,
            $quantity,
            $inventoryLocationId,
            InventoryTransactionType::SHIPPED
        );

        $handler = new AdjustInventoryHandler($inventoryService, $productService);
        $handler->handle($command);
    }
}
