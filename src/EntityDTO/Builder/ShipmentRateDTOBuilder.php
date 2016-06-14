<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;

class ShipmentRateDTOBuilder implements DTOBuilderInterface
{
    /** @var ShipmentRate */
    protected $entity;

    /** @var ShipmentRateDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(ShipmentRate $shipmentRate, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $shipmentRate;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new ShipmentRateDTO;
        $this->entityDTO->externalId = $this->entity->getExternalId();
        $this->entityDTO->shipmentExternalId = $this->entity->getShipmentExternalId();
        $this->entityDTO->service    = $this->entity->getService();
        $this->entityDTO->carrier    = $this->entity->getCarrier();

        $this->entityDTO->rate = $this->dtoBuilderFactory
            ->getMoneyDTOBuilder($this->entity->getRate())
            ->build();

        $this->entityDTO->isDeliveryDateGuaranteed = $this->entity->isDeliveryDateGuaranteed();
        $this->entityDTO->deliveryDays             = $this->entity->getDeliveryDays();
        $this->entityDTO->estDeliveryDays          = $this->entity->getEstDeliveryDays();

        if ($this->entity->getDeliveryMethod()->getId() !== null) {
            $this->entityDTO->deliveryMethod = $this->dtoBuilderFactory
                ->getDeliveryMethodTypeDTOBuilder($this->entity->getDeliveryMethod())
                ->build();
        }

        if ($this->entity->getDeliveryDate() !== null) {
            $this->entityDTO->deliveryDate = $this->entity->getDeliveryDate();
        }

        if ($this->entity->getListRate() !== null) {
            $this->entityDTO->listRate = $this->dtoBuilderFactory
                ->getMoneyDTOBuilder($this->entity->getListRate())
                ->build();
        }

        if ($this->entity->getRetailRate() !== null) {
            $this->entityDTO->retailRate = $this->dtoBuilderFactory
                ->getMoneyDTOBuilder($this->entity->getRetailRate())
                ->build();
        }

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
