<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\ShipmentLabel;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\ShipmentTracker;

class ShipmentTrackerDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $shipmentTracker = new ShipmentTracker(ShipmentTracker::CARRIER_UPS, 'xxxx');
        $shipmentTracker->setShipmentRate(new ShipmentRate(new Money(1, 'USD')));
        $shipmentTracker->setShipmentLabel(new ShipmentLabel);

        $shipmentTrackerDTO = $shipmentTracker->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentTrackerDTO instanceof ShipmentTrackerDTO);
        $this->assertTrue($shipmentTrackerDTO->shipmentRate instanceof ShipmentRateDTO);
        $this->assertTrue($shipmentTrackerDTO->shipmentLabel instanceof ShipmentLabelDTO);
    }
}
