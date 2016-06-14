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

        $product = $this->dummyData->getProduct();
        $inventoryLocation = $this->dummyData->getInventoryLocation();
        $quantity = 3;

        $command = new AdjustInventoryCommand(
            $product->getId(),
            $quantity,
            $inventoryLocation->getId(),
            InventoryTransactionType::SHIPPED
        );

        $handler = new AdjustInventoryHandler($inventoryService, $productService);
        $handler->handle($command);
    }
}
