<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $shipment = new Shipment;
        $shipment->addShipmentTracker(
            new ShipmentTracker(
                ShipmentTracker::CARRIER_UPS,
                '1Z9999999999999999'
            )
        );

        $shipment->addShipmentItem(
            new ShipmentItem(
                new OrderItem,
                1
            )
        );

        $shipment->addShipmentComment(new ShipmentComment('Enjoy your items!'));
        $shipment->setOrder(new Order);

        $this->assertEntityValid($shipment);
        $this->assertTrue($shipment->getShipmentTrackers()[0] instanceof ShipmentTracker);
        $this->assertTrue($shipment->getShipmentItems()[0] instanceof ShipmentItem);
        $this->assertTrue($shipment->getShipmentComments()[0] instanceof ShipmentComment);
        $this->assertTrue($shipment->getOrder() instanceof Order);
    }
}
