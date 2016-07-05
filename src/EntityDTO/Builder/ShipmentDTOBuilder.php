<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\EntityDTO\ShipmentDTO;

class ShipmentDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var Shipment */
    protected $entity;

    /** @var ShipmentDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(Shipment $shipment, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $shipment;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new ShipmentDTO;
        $this->setId();
        $this->setTime();

        foreach ($this->entity->getShipmentTrackers() as $shipmentTracker) {
            $this->entityDTO->shipmentTrackers[] = $this->dtoBuilderFactory
                ->getShipmentTrackerDTOBuilder($shipmentTracker)
                ->build();
        }

        foreach ($this->entity->getShipmentItems() as $hipmentTrack) {
            $this->entityDTO->shipmentItems[] = $this->dtoBuilderFactory
                ->getShipmentItemDTOBuilder($hipmentTrack)
                ->build();
        }

        foreach ($this->entity->getShipmentComments() as $shipmentComment) {
            $this->entityDTO->shipmentComments[] = $this->dtoBuilderFactory
                ->getShipmentCommentDTOBuilder($shipmentComment)
                ->build();
        }
    }

    /**
     * @return static
     */
    public function withOrder()
    {
        $this->entityDTO->order = $this->dtoBuilderFactory
            ->getOrderDTOBuilder($this->entity->getOrder())
            ->build();

        return $this;
    }

    /**
     * @return static
     */
    public function withAllData()
    {
        return $this->withOrder();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
