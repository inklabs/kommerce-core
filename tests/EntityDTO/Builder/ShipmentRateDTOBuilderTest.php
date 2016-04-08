<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentRateDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $shipmentRate = $this->dummyData->getShipmentRate();

        $shipmentRateDTO = $shipmentRate->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentRateDTO instanceof ShipmentRateDTO);
    }
}
