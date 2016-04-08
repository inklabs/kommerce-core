<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\ShipmentComment;

class ShipmentCommentDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $shipmentComment = new ShipmentComment('A comment');

        $shipmentCommentDTO = $shipmentComment->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentCommentDTO instanceof ShipmentCommentDTO);
    }
}
