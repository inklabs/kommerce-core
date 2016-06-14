<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\EntityDTO\InventoryLocationDTO;
use inklabs\kommerce\EntityDTO\WarehouseDTO;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class InventoryLocationDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $inventoryLocation = $this->dummyData->getInventoryLocation();

        $inventoryLocationDTO = $this->getDTOBuilderFactory()
            ->getInventoryLocationDTOBuilder($inventoryLocation)
            ->withAllData()
            ->build();

        $this->assertTrue($inventoryLocationDTO instanceof InventoryLocationDTO);
        $this->assertTrue($inventoryLocationDTO->warehouse instanceof WarehouseDTO);
    }
}
