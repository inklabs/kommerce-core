<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentTrackerTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $shipmentTracking = new ShipmentTracker(
            ShipmentTracker::CARRIER_UPS,
            '1Z9999999999999999'
        );

        $shipmentTracking->setExternalId('trk_84ec7e2c5a224222a6e129ce927b936x');
        $shipmentTracking->setShipmentRate(new ShipmentRate(new Money(225, 'USD')));
        $shipmentTracking->setShipmentLabel(new ShipmentLabel);

        $this->assertEntityValid($shipmentTracking);
        $this->assertSame(ShipmentTracker::CARRIER_UPS, $shipmentTracking->getCarrier());
        $this->assertSame('1Z9999999999999999', $shipmentTracking->getTrackingCode());
        $this->assertTrue($shipmentTracking->getShipmentRate() instanceof ShipmentRate);
        $this->assertTrue($shipmentTracking->getShipmentLabel() instanceof ShipmentLabel);
    }
}
