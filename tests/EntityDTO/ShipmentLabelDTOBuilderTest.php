<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\ShipmentLabel;

class ShipmentLabelDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $shipmentLabel = new ShipmentLabel;

        $shipmentLabelDTO = $shipmentLabel->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentLabelDTO instanceof ShipmentLabelDTO);
    }
}
