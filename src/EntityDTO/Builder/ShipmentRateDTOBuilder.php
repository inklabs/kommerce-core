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
        $this->shipmentRateDTO->id                  = $this->shipmentRate->getId();
        $this->shipmentRateDTO->encodedId           = BaseConvert::encode($this->shipmentRate->getId());
        $this->shipmentRateDTO->rate                = $this->shipmentRate->getRate()->getDTOBuilder()->build();
        $this->shipmentRateDTO->created             = $this->shipmentRate->getCreated();
        $this->shipmentRateDTO->updated             = $this->shipmentRate->getUpdated();

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
