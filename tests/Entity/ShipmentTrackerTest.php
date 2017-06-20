<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ShipmentTrackerTest extends EntityTestCase
{
    public function testCreate()
    {
        $carrier = $this->dummyData->getShipmentCarrierType();
        $shipmentRate = $this->dummyData->getShipmentRate();
        $shipmentLabel = $this->dummyData->getShipmentLabel();

        $shipmentTracking = new ShipmentTracker(
            $carrier,
            '1Z9999999999999999'
        );
        $shipmentTracking->setExternalId('trk_84ec7e2c5a224222a6e129ce927b936x');
        $shipmentTracking->setShipmentRate($shipmentRate);
        $shipmentTracking->setShipmentLabel($shipmentLabel);

        $this->assertEntityValid($shipmentTracking);
        $this->assertSame($carrier, $shipmentTracking->getCarrier());
        $this->assertSame('1Z9999999999999999', $shipmentTracking->getTrackingCode());
        $this->assertSame($shipmentRate, $shipmentTracking->getShipmentRate());
        $this->assertSame($shipmentLabel, $shipmentTracking->getShipmentLabel());
    }
}
