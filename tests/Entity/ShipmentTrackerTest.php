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

        $shipmentTracking->setExternalId('trk_Txyy1vaM');
        $shipmentTracking->setShipmentRate(new ShipmentRate(225));
        $shipmentTracking->setShipmentLabel(new ShipmentLabel);

        $this->assertEntityValid($shipmentTracking);
        $this->assertSame(ShipmentTracker::CARRIER_UPS, $shipmentTracking->getCarrier());
        $this->assertSame('1Z9999999999999999', $shipmentTracking->getTrackingCode());
        $this->assertTrue($shipmentTracking->getShipmentRate() instanceof ShipmentRate);
        $this->assertTrue($shipmentTracking->getShipmentLabel() instanceof ShipmentLabel);
    }
}
