<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\ShipmentTrackerDTO;

class ShipmentTrackerDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var ShipmentTracker */
    protected $entity;

    /** @var ShipmentTrackerDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(ShipmentTracker $shipmentTracker, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $shipmentTracker;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new ShipmentTrackerDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->trackingCode = $this->entity->getTrackingCode();
        $this->entityDTO->externalId   = $this->entity->getExternalId();

        $this->entityDTO->carrier = $this->dtoBuilderFactory
            ->getShipmentCarrierTypeDTOBuilder($this->entity->getCarrier())
            ->build();

        if ($this->entity->getShipmentRate() !== null) {
            $this->entityDTO->shipmentRate = $this->dtoBuilderFactory
                ->getShipmentRateDTOBuilder($this->entity->getShipmentRate())
                ->build();
        }

        if ($this->entity->getShipmentLabel() !== null) {
            $this->entityDTO->shipmentLabel = $this->dtoBuilderFactory
                ->getShipmentLabelDTOBuilder($this->entity->getShipmentLabel())
                ->build();
        }
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->entityDTO;
    }
}
