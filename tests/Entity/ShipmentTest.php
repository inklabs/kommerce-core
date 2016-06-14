<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ShipmentTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $shipment = new Shipment();
        $order = $this->dummyData->getOrder();
        $order->addShipment($shipment);

        $this->assertSame($order, $shipment->getOrder());
        $this->assertSame(0, count($shipment->getShipmentTrackers()));
        $this->assertSame(0, count($shipment->getShipmentItems()));
        $this->assertSame(0, count($shipment->getShipmentComments()));
    }

    public function testCreate()
    {
        $shipmentTracker = $this->dummyData->getShipmentTracker();

        $shipment = new Shipment();
        $shipment->addShipmentTracker($shipmentTracker);

        $order = $this->dummyData->getOrder();
        $order->addShipment($shipment);

        $shipmentItem = $this->dummyData->getShipmentItem($shipment);
        $shipmentComment = $this->dummyData->getShipmentComment($shipment);

        $this->assertEntityValid($shipment);
        $this->assertSame($order, $shipment->getOrder());
        $this->assertSame($shipmentTracker, $shipment->getShipmentTrackers()[0]);
        $this->assertSame($shipmentItem, $shipment->getShipmentItems()[0]);
        $this->assertSame($shipmentComment, $shipment->getShipmentComments()[0]);
    }
}
