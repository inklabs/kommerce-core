<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class WarehouseDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);

        $warehouseDTO = $this->getDTOBuilderFactory()->getWarehouseDTOBuilder($warehouse)
            ->withAllData()
            ->build();

        $this->assertTrue($warehouseDTO instanceof WarehouseDTO);
        $this->assertTrue($warehouseDTO->address instanceof AddressDTO);
        $this->assertTrue($warehouseDTO->address->point instanceof PointDTO);
        $this->assertTrue($warehouseDTO->inventoryLocations[0] instanceof InventoryLocationDTO);
    }
}
