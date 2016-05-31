<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;

class ShipmentRateDTOBuilder
{
    /** @var ShipmentRateDTO */
    protected $shipmentRateDTO;

    /** @var ShipmentRate */
    protected $shipmentRate;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(ShipmentRate $shipmentRate, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->shipmentRate = $shipmentRate;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->shipmentRateDTO = new ShipmentRateDTO;
        $this->shipmentRateDTO->externalId = $this->shipmentRate->getExternalId();
        $this->shipmentRateDTO->shipmentExternalId = $this->shipmentRate->getShipmentExternalId();
        $this->shipmentRateDTO->service    = $this->shipmentRate->getService();
        $this->shipmentRateDTO->carrier    = $this->shipmentRate->getCarrier();

        $this->shipmentRateDTO->rate = $this->dtoBuilderFactory
            ->getMoneyDTOBuilder($this->shipmentRate->getRate())
            ->build();

        $this->shipmentRateDTO->isDeliveryDateGuaranteed = $this->shipmentRate->isDeliveryDateGuaranteed();
        $this->shipmentRateDTO->deliveryDays             = $this->shipmentRate->getDeliveryDays();
        $this->shipmentRateDTO->estDeliveryDays          = $this->shipmentRate->getEstDeliveryDays();

        if ($this->shipmentRate->getDeliveryMethod()->getId() !== null) {
            $this->shipmentRateDTO->deliveryMethod = $this->dtoBuilderFactory
                ->getDeliveryMethodTypeDTOBuilder($this->shipmentRate->getDeliveryMethod())
                ->build();
        }

        if ($this->shipmentRate->getDeliveryDate() !== null) {
            $this->shipmentRateDTO->deliveryDate = $this->shipmentRate->getDeliveryDate();
        }

        if ($this->shipmentRate->getListRate() !== null) {
            $this->shipmentRateDTO->listRate = $this->dtoBuilderFactory
                ->getMoneyDTOBuilder($this->shipmentRate->getListRate())
                ->build();
        }

        if ($this->shipmentRate->getRetailRate() !== null) {
            $this->shipmentRateDTO->retailRate = $this->dtoBuilderFactory
                ->getMoneyDTOBuilder($this->shipmentRate->getRetailRate())
                ->build();
        }

    }

    public function build()
    {
        return $this->shipmentRateDTO;
    }
}
