<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentItemDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $shipmentItem = $this->dummyData->getShipmentItem();

        $shipmentItemDTO = $shipmentItem->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentItemDTO instanceof ShipmentItemDTO);
        $this->assertTrue($shipmentItemDTO->orderItem instanceof OrderItemDTO);
    }
}
