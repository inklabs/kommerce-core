<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ShipmentTrackerDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $shipmentTracker = $this->dummyData->getShipmentTracker();

        $shipmentTrackerDTO = $shipmentTracker->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentTrackerDTO instanceof ShipmentTrackerDTO);
        $this->assertTrue($shipmentTrackerDTO->shipmentRate instanceof ShipmentRateDTO);
        $this->assertTrue($shipmentTrackerDTO->shipmentLabel instanceof ShipmentLabelDTO);
    }
}
