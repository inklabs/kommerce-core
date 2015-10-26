<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\EntityDTO\ShipmentItemDTO;
use inklabs\kommerce\Lib\BaseConvert;

class ShipmentItemDTOBuilder
{
    /** @var ShipmentItem */
    private $shipmentItem;

    public function __construct(ShipmentItem $shipmentItem)
    {
        $this->shipmentItem = $shipmentItem;

        $this->shipmentItemDTO = new ShipmentItemDTO;
        $this->shipmentItemDTO->id              = $this->shipmentItem->getId();
        $this->shipmentItemDTO->encodedId       = BaseConvert::encode($this->shipmentItem->getId());
        $this->shipmentItemDTO->created         = $this->shipmentItem->getCreated();
        $this->shipmentItemDTO->updated         = $this->shipmentItem->getUpdated();

        $this->shipmentItemDTO->orderItem = $this->shipmentItem->getOrderItem()->getDTOBuilder()
            ->build();
    }

    public function build()
    {
        return $this->shipmentItemDTO;
    }
}
