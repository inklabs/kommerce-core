<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\EntityDTO\ShipmentRateDTO;
use inklabs\kommerce\Lib\BaseConvert;

class ShipmentRateDTOBuilder
{
    /** @var ShipmentRateDTO */
    protected $shipmentRateDTO;

    /** @var ShipmentRate */
    protected $shipmentRate;

    public function __construct(ShipmentRate $shipmentRate)
    {
        $this->shipmentRate = $shipmentRate;

        $this->shipmentRateDTO = new ShipmentRateDTO;
        $this->shipmentRateDTO->id         = $this->shipmentRate->getId();
        $this->shipmentRateDTO->encodedId  = BaseConvert::encode($this->shipmentRate->getId());
        $this->shipmentRateDTO->externalId = $this->shipmentRate->getExternalId();
        $this->shipmentRateDTO->service    = $this->shipmentRate->getService();
        $this->shipmentRateDTO->carrier    = $this->shipmentRate->getCarrier();
        $this->shipmentRateDTO->rate       = $this->shipmentRate->getRate()->getDTOBuilder()->build();
        $this->shipmentRateDTO->created    = $this->shipmentRate->getCreated();
        $this->shipmentRateDTO->updated    = $this->shipmentRate->getUpdated();

        $this->shipmentRateDTO->isDeliveryDateGuaranteed = $this->shipmentRate->isDeliveryDateGuaranteed();
        $this->shipmentRateDTO->deliveryDays             = $this->shipmentRate->getDeliveryDays();
        $this->shipmentRateDTO->estDeliveryDays          = $this->shipmentRate->getEstDeliveryDays();

        if ($this->shipmentRate->getDeliveryDate() !== null) {
            $this->shipmentRateDTO->deliveryDate = $this->shipmentRate->getDeliveryDate();
        }

        if ($this->shipmentRate->getListRate() !== null) {
            $this->shipmentRateDTO->listRate = $this->shipmentRate->getListRate()->getDTOBuilder()->build();
        }

        if ($this->shipmentRate->getRetailRate() !== null) {
            $this->shipmentRateDTO->retailRate = $this->shipmentRate->getRetailRate()->getDTOBuilder()->build();
        }

    }

    public function build()
    {
        return $this->shipmentRateDTO;
    }
}
