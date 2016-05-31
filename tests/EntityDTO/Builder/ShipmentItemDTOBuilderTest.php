<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ShipmentItemDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $shipmentItem = $this->dummyData->getShipmentItem();

        $shipmentItemDTO = $this->getDTOBuilderFactory()
            ->getShipmentItemDTOBuilder($shipmentItem)
            ->build();

        $this->assertTrue($shipmentItemDTO instanceof ShipmentItemDTO);
        $this->assertTrue($shipmentItemDTO->orderItem instanceof OrderItemDTO);
    }
}
