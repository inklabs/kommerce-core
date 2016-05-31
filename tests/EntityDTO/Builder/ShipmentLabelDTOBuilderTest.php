<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ShipmentLabelDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $shipmentLabel = $this->dummyData->getShipmentLabel();

        $shipmentLabelDTO = $this->getDTOBuilderFactory()
            ->getShipmentLabelDTOBuilder($shipmentLabel)
            ->build();

        $this->assertTrue($shipmentLabelDTO instanceof ShipmentLabelDTO);
    }
}
