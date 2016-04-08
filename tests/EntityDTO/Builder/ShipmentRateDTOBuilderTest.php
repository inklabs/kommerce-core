<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ShipmentRateDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $shipmentRate = $this->dummyData->getShipmentRate();

        $shipmentRateDTO = $shipmentRate->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentRateDTO instanceof ShipmentRateDTO);
    }
}
