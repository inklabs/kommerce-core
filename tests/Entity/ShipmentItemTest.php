<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ShipmentItemTest extends EntityTestCase
{
    public function testCreate()
    {
        $shipment = $this->dummyData->getShipment();
        $orderItem = $this->dummyData->getOrderItem();

        $shipmentItem = new ShipmentItem($shipment, $orderItem, 1);

        $this->assertEntityValid($shipmentItem);
        $this->assertSame(1, $shipmentItem->getQuantityToShip());
        $this->assertSame($orderItem, $shipmentItem->getOrderItem());
    }
}
