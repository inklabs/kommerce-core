<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentItemTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $orderItem = $this->dummyData->getOrderItem();
        $shipment = $this->dummyData->getShipment();

        $shipmentItem = new ShipmentItem($orderItem, 1);
        $shipmentItem->setShipment($shipment);

        $this->assertEntityValid($shipmentItem);
        $this->assertSame(1, $shipmentItem->getQuantityToShip());
        $this->assertSame($orderItem, $shipmentItem->getOrderItem());
    }
}
