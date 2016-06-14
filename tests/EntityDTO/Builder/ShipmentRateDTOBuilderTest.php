<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ShipmentRateDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $shipmentRate = $this->dummyData->getShipmentRate();

        $shipmentRateDTO = $this->getDTOBuilderFactory()
            ->getShipmentRateDTOBuilder($shipmentRate)
            ->build();

        $this->assertTrue($shipmentRateDTO instanceof ShipmentRateDTO);
        $this->assertTrue($shipmentRateDTO->deliveryMethod instanceof DeliveryMethodTypeDTO);
    }
}
