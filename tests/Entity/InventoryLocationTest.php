<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class InventoryLocationTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = new InventoryLocation($warehouse, 'Widget Bin', 'Z1-A13-B37-L5-P3');
        // Zone 1 - Aisle 13 - Bay 37 - Level 5 - Position 3

        $this->assertEntityValid($inventoryLocation);
        $this->assertTrue($inventoryLocation->getWarehouse() instanceof Warehouse);
        $this->assertTrue($inventoryLocation->getCreated() instanceof DateTime);
        $this->assertSame('Widget Bin', $inventoryLocation->getName());
        $this->assertSame('Z1-A13-B37-L5-P3', $inventoryLocation->getCode());
    }
}
