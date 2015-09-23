<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShippingRate;
use inklabs\kommerce\EntityDTO\ShippingRateDTO;

class ShippingRateDTOBuilder
{
    /** @var ShippingRate */
    protected $shippingRate;

    /** @var ShippingRateDTO */
    protected $shippingRateDTO;

    public function __construct(ShippingRate $shippingRate)
    {
        $this->shippingRate = $shippingRate;

        $this->shippingRateDTO = new ShippingRateDTO();
        $this->shippingRateDTO->code           = $this->shippingRate->getCode();
        $this->shippingRateDTO->name           = $this->shippingRate->getName();
        $this->shippingRateDTO->cost           = $this->shippingRate->getCost();
        $this->shippingRateDTO->deliveryTs     = $this->shippingRate->getDeliveryTs();
        $this->shippingRateDTO->transitTime    = $this->shippingRate->getTransitTime();
        $this->shippingRateDTO->weightInPounds = $this->shippingRate->getWeightInPounds();
        $this->shippingRateDTO->shipMethod     = $this->shippingRate->getShipMethod();
        $this->shippingRateDTO->zip5           = $this->shippingRate->getZip5();
        $this->shippingRateDTO->state          = $this->shippingRate->getState();
        $this->shippingRateDTO->isResidential  = $this->shippingRate->isResidential();
    }

    public function build()
    {
        return $this->shippingRateDTO;
    }
}
