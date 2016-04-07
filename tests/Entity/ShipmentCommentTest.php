<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentCommentTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $shipment = $this->dummyData->getShipment();

        $shipmentComment = new ShipmentComment('Enjoy your items!');
        $shipmentComment->setShipment($shipment);

        $this->assertEntityValid($shipmentComment);
        $this->assertSame('Enjoy your items!', $shipmentComment->getComment());
    }
}
