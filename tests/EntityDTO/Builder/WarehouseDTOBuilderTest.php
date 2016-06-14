<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class WarehouseDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $warehouse = $this->dummyData->getWarehouse();

        $warehouseDTO = $this->getDTOBuilderFactory()->getWarehouseDTOBuilder($warehouse)
            ->build();

        $this->assertTrue($warehouseDTO instanceof WarehouseDTO);
        $this->assertTrue($warehouseDTO->address instanceof AddressDTO);
        $this->assertTrue($warehouseDTO->address->point instanceof PointDTO);
    }
}
