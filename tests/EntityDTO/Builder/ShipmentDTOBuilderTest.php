<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ShipmentDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $shipmentTracker = $this->dummyData->getShipmentTracker();

        $shipment = $this->dummyData->getShipment();
        $shipment->setOrder($this->dummyData->getOrder());
        $shipment->addShipmentTracker($shipmentTracker);

        $this->dummyData->getShipmentItem($shipment);
        $this->dummyData->getShipmentComment($shipment);

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
