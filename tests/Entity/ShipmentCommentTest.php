<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ShipmentCommentTest extends EntityTestCase
{
    public function testCreate()
    {
        $shipment = $this->dummyData->getShipment();

        $shipmentComment = new ShipmentComment($shipment, 'Enjoy your items!');

        $this->assertEntityValid($shipmentComment);
        $this->assertSame('Enjoy your items!', $shipmentComment->getComment());
    }
}
