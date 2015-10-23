<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentItemTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $shipmentItem = new ShipmentItem(new OrderItem, 1);

        $this->assertEntityValid($shipmentItem);
        $this->assertTrue($shipmentItem->getOrderItem() instanceof OrderItem);
        $this->assertSame(1, $shipmentItem->getQuantityToShip());
    }
}
