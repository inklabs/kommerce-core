<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ShipmentTrackerTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $shipmentTracking = new ShipmentTracker(
            ShipmentTracker::CARRIER_UPS,
            '1Z9999999999999999'
        );

        $this->assertSame(null, $shipmentTracking->getShipmentRate());
        $this->assertSame(null, $shipmentTracking->getShipmentLabel());
    }

    public function testCreate()
    {
        $shipmentRate = $this->dummyData->getShipmentRate();
        $shipmentLabel = $this->dummyData->getShipmentLabel();

        $shipmentTracking = new ShipmentTracker(
            ShipmentTracker::CARRIER_UPS,
            '1Z9999999999999999'
        );
        $shipmentTracking->setExternalId('trk_84ec7e2c5a224222a6e129ce927b936x');
        $shipmentTracking->setShipmentRate($shipmentRate);
        $shipmentTracking->setShipmentLabel($shipmentLabel);

        $this->assertEntityValid($shipmentTracking);
        $this->assertSame(ShipmentTracker::CARRIER_UPS, $shipmentTracking->getCarrier());
        $this->assertSame('1Z9999999999999999', $shipmentTracking->getTrackingCode());
        $this->assertSame($shipmentRate, $shipmentTracking->getShipmentRate());
        $this->assertSame($shipmentLabel, $shipmentTracking->getShipmentLabel());
    }
}
