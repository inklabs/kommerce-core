<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ShipmentCommentDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $shipmentComment = $this->dummyData->getShipmentComment();

        $shipmentCommentDTO = $this->getDTOBuilderFactory()
            ->getShipmentCommentDTOBuilder($shipmentComment)
            ->build();

        $this->assertTrue($shipmentCommentDTO instanceof ShipmentCommentDTO);
    }
}
