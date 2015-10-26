<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\EntityDTO\ShipmentDTO;
use inklabs\kommerce\Lib\BaseConvert;

class ShipmentDTOBuilder
{
    /** @var Shipment */
    protected $shipment;

    /** @var ShipmentDTO */
    protected $shipmentDTO;

    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;

        $this->shipmentDTO = new ShipmentDTO;
        $this->shipmentDTO->id              = $this->shipment->getId();
        $this->shipmentDTO->encodedId       = BaseConvert::encode($this->shipment->getId());
        $this->shipmentDTO->created         = $this->shipment->getCreated();
        $this->shipmentDTO->updated         = $this->shipment->getUpdated();

        foreach ($this->shipment->getShipmentTrackers() as $shipmentItem) {
            $this->shipmentDTO->shipmentTrackers[] = $shipmentItem->getDTOBuilder()
                ->build();
        }

        foreach ($this->shipment->getShipmentItems() as $shipmentItem) {
            $this->shipmentDTO->shipmentItems[] = $shipmentItem->getDTOBuilder()
                ->build();
        }

        foreach ($this->shipment->getShipmentComments() as $shipmentComment) {
            $this->shipmentDTO->shipmentComments[] = $shipmentComment->getDTOBuilder()
                ->build();
        }
    }

    public function withOrder()
    {
        $this->shipmentDTO->order = $this->shipment->getOrder()->getDTOBuilder()
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
