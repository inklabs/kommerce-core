<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentTest extends DoctrineTestCase
{
    public function testCreateDefaults()
    {
        $shipment = new Shipment;

        $this->assertSame(null, $shipment->getOrder());
        $this->assertSame(0, count($shipment->getShipmentTrackers()));
        $this->assertSame(0, count($shipment->getShipmentItems()));
        $this->assertSame(0, count($shipment->getShipmentComments()));
    }

    public function testCreate()
    {
        $shipmentTracker = $this->dummyData->getShipmentTracker();
        $shipmentItem = $this->dummyData->getShipmentItem();
        $shipmentComment = $this->dummyData->getShipmentComment();
        $order = $this->dummyData->getOrder();

        $shipment = new Shipment;
        $shipment->setOrder($order);
        $shipment->addShipmentTracker($shipmentTracker);
        $shipment->addShipmentItem($shipmentItem);
        $shipment->addShipmentComment($shipmentComment);

        $this->assertEntityValid($shipment);
        $this->assertSame($order, $shipment->getOrder());
        $this->assertSame($shipmentTracker, $shipment->getShipmentTrackers()[0]);
        $this->assertSame($shipmentItem, $shipment->getShipmentItems()[0]);
        $this->assertSame($shipmentComment, $shipment->getShipmentComments()[0]);
    }
}
