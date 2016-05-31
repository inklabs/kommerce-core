<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\ShipmentTrackerDTO;

class ShipmentTrackerDTOBuilder
{
    /** @var ShipmentTracker */
    protected $shipmentTracker;

    /** @var ShipmentTrackerDTO */
    protected $shipmentTrackerDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(ShipmentTracker $shipmentTracker, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->shipmentTracker = $shipmentTracker;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->shipmentTrackerDTO = new ShipmentTrackerDTO;
        $this->shipmentTrackerDTO->id           = $this->shipmentTracker->getId();
        $this->shipmentTrackerDTO->created      = $this->shipmentTracker->getCreated();
        $this->shipmentTrackerDTO->updated      = $this->shipmentTracker->getUpdated();
        $this->shipmentTrackerDTO->trackingCode = $this->shipmentTracker->getTrackingCode();
        $this->shipmentTrackerDTO->externalId   = $this->shipmentTracker->getExternalId();

        $this->shipmentTrackerDTO->carrier = $this->dtoBuilderFactory
            ->getShipmentCarrierTypeDTOBuilder($this->shipmentTracker->getCarrier())
            ->build();

        if ($this->shipmentTracker->getShipmentRate() !== null) {
            $this->shipmentTrackerDTO->shipmentRate = $this->dtoBuilderFactory
                ->getShipmentRateDTOBuilder($this->shipmentTracker->getShipmentRate())
                ->build();
        }

        if ($this->shipmentTracker->getShipmentLabel() !== null) {
            $this->shipmentTrackerDTO->shipmentLabel = $this->dtoBuilderFactory
                ->getShipmentLabelDTOBuilder($this->shipmentTracker->getShipmentLabel())
                ->build();
        }
    }

    public function build()
    {
        return $this->shipmentTrackerDTO;
    }
}
