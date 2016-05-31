<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\EntityDTO\ShipmentDTO;

class ShipmentDTOBuilder
{
    /** @var Shipment */
    protected $shipment;

    /** @var ShipmentDTO */
    protected $shipmentDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(Shipment $shipment, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->shipment = $shipment;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->shipmentDTO = new ShipmentDTO;
        $this->shipmentDTO->id      = $this->shipment->getId();
        $this->shipmentDTO->created = $this->shipment->getCreated();
        $this->shipmentDTO->updated = $this->shipment->getUpdated();

        foreach ($this->shipment->getShipmentTrackers() as $shipmentTracker) {
            $this->shipmentDTO->shipmentTrackers[] = $this->dtoBuilderFactory
                ->getShipmentTrackerDTOBuilder($shipmentTracker)
                ->build();
        }

        foreach ($this->shipment->getShipmentItems() as $hipmentTrack) {
            $this->shipmentDTO->shipmentItems[] = $this->dtoBuilderFactory
                ->getShipmentItemDTOBuilder($hipmentTrack)
                ->build();
        }

        foreach ($this->shipment->getShipmentComments() as $shipmentComment) {
            $this->shipmentDTO->shipmentComments[] = $this->dtoBuilderFactory
                ->getShipmentCommentDTOBuilder($shipmentComment)
                ->build();
        }
    }

    public function withOrder()
    {
        $this->shipmentDTO->order = $this->dtoBuilderFactory
            ->getOrderDTOBuilder($this->shipment->getOrder())
            ->build();

        return $this;
    }

    public function build()
    {
        return $this->shipmentDTO;
    }

    public function withAllData()
    {
        return
            $this->withOrder();
    }
}
