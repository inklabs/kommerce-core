<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class ShippingRate
{
    /** @var string */
    public $code;

    /** @var string */
    public $name;

    /** @var int */
    public $cost;

    /** @var int */
    public $deliveryTs;

    /** @var string */
    public $transitTime;

    /** @var int */
    public $weightInPounds;

    /** @var string */
    public $shipMethod;

    /** @var string */
    public $zip5;

    /** @var string */
    public $state;

    /** @var bool */
    public $isResidential;

    public function __construct(Entity\ShippingRate $shippingRate)
    {
        $this->code = $shippingRate->getCode();
        $this->name = $shippingRate->getName();
        $this->cost = $shippingRate->getCost();
        $this->deliveryTs = $shippingRate->getDeliveryTs();
        $this->transitTime = $shippingRate->getTransitTime();
        $this->weightInPounds = $shippingRate->getWeightInPounds();
        $this->shipMethod = $shippingRate->getShipMethod();
        $this->zip5 = $shippingRate->getZip5();
        $this->state = $shippingRate->getState();
        $this->isResidential = $shippingRate->isResidential();
    }

    public function export()
    {
        return $this;
    }
}
