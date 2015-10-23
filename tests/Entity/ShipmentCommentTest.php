<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentCommentTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $shipmentComment = new ShipmentComment('Enjoy your items!');

        $this->assertEntityValid($shipmentComment);
        $this->assertSame('Enjoy your items!', $shipmentComment->getComment());
    }
}
