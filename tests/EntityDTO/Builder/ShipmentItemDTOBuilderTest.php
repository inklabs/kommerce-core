<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\ShipmentItem;

class ShipmentItemDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $shipmentItem = new ShipmentItem(new Orderitem, 1);

        $shipmentItemDTO = $shipmentItem->getDTOBuilder()
            ->build();

        $this->assertTrue($shipmentItemDTO instanceof ShipmentItemDTO);
        $this->assertTrue($shipmentItemDTO->orderItem instanceof OrderItemDTO);
    }
}
