<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\EntityDTO\ShipmentItemDTO;

class ShipmentItemDTOBuilder
{
    /** @var ShipmentItem */
    private $shipmentItem;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(ShipmentItem $shipmentItem, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->shipmentItem = $shipmentItem;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->shipmentItemDTO = new ShipmentItemDTO;
        $this->shipmentItemDTO->id      = $this->shipmentItem->getId();
        $this->shipmentItemDTO->created = $this->shipmentItem->getCreated();
        $this->shipmentItemDTO->updated = $this->shipmentItem->getUpdated();

        $this->shipmentItemDTO->orderItem = $this->dtoBuilderFactory
            ->getOrderItemDTOBuilder($this->shipmentItem->getOrderItem())
            ->build();
    }

    public function build()
    {
        return $this->shipmentItemDTO;
    }
}
