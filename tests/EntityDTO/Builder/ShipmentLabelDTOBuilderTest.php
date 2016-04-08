<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentLabelDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $shipmentLabel = $this->dummyData->getShipmentLabel();

        $shipmentLabelDTO = $shipmentLabel->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentLabelDTO instanceof ShipmentLabelDTO);
    }
}
