<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\Entity\ShipmentTracker;

class ShipmentDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $shipment = new Shipment;
        $shipment->addShipmentTracker(new ShipmentTracker(ShipmentTracker::CARRIER_UPS, 'xxxx'));
        $shipment->addShipmentItem(new ShipmentItem(new OrderItem, 1));
        $shipment->addShipmentComment(new ShipmentComment('A comment'));
        $shipment->setOrder(new Order);

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
