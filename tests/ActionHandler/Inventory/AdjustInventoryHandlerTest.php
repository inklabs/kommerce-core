<?php
namespace inklabs\kommerce\ActionHandler\Inventory;

use inklabs\kommerce\Action\Inventory\AdjustInventoryCommand;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\InventoryTransactionType;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AdjustInventoryHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        InventoryLocation::class,
        InventoryTransaction::class,
        Warehouse::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);
        $this->persistEntityAndFlushClear([
            $product,
            $warehouse,
            $inventoryLocation,
        ]);
        $quantity = 3;
        $command = new AdjustInventoryCommand(
            $product->getId()->getHex(),
            $quantity,
            $inventoryLocation->getId()->getHex(),
            InventoryTransactionType::SHIPPED
        );

        $this->dispatchCommand($command);
    }
}
