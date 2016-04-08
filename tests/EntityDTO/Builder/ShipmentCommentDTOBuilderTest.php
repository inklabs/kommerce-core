<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentCommentDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $shipmentComment = $this->dummyData->getShipmentComment();

        $shipmentCommentDTO = $shipmentComment->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentCommentDTO instanceof ShipmentCommentDTO);
    }
}
