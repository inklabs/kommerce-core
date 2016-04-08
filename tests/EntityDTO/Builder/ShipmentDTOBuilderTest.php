<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $shipment = $this->dummyData->getShipment();
        $shipment->setOrder($this->dummyData->getOrder());

        $shipmentDTO = $shipment->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($shipmentDTO instanceof ShipmentDTO);
        $this->assertTrue($shipmentDTO->shipmentTrackers[0] instanceof ShipmentTrackerDTO);
        $this->assertTrue($shipmentDTO->shipmentItems[0] instanceof ShipmentItemDTO);
        $this->assertTrue($shipmentDTO->shipmentComments[0] instanceof ShipmentCommentDTO);
        $this->assertTrue($shipmentDTO->order instanceof OrderDTO);
    }
}
