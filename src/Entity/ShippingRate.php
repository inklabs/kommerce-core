<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;

class ShippingRate
{
    /** @var string */
    protected $code;

    /** @var string */
    protected $name;

    /** @var int */
    protected $cost;

    /** @var int */
    protected $deliveryTs;

    /** @var string */
    protected $transitTime;

    /** @var int */
    protected $weightInPounds;

    /** @var string */
    protected $shipMethod;

    /** @var string */
    protected $zip5;

    /** @var string */
    protected $state;

    /** @var bool */
    protected $isResidential;

    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = (string) $code;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     */
    public function setCost($cost)
    {
        $this->cost = (int) $cost;
    }

    public function getDeliveryTs()
    {
        return $this->deliveryTs;
    }

    /**
     * @param int $deliveryTs
     */
    public function setDeliveryTs($deliveryTs)
    {
        $this->deliveryTs = (int) $deliveryTs;
    }

    public function getTransitTime()
    {
        return $this->transitTime;
    }

    /**
     * @param string $transitTime
     */
    public function setTransitTime($transitTime)
    {
        $this->transitTime = (string) $transitTime;
    }

    public function getWeightInPounds()
    {
        return $this->weightInPounds;
    }

    /**
     * @param int $weightInPounds
     */
    public function setWeightInPounds($weightInPounds)
    {
        $this->weightInPounds = (int) $weightInPounds;
    }

    public function getShipMethod()
    {
        return $this->shipMethod;
    }

    /**
     * @param string $shipMethod
     */
    public function setShipMethod($shipMethod)
    {
        $this->shipMethod = (string) $shipMethod;
    }

    public function getZip5()
    {
        return $this->zip5;
    }

    /**
     * @param string $zip5
     */
    public function setZip5($zip5)
    {
        $this->zip5 = (string) $zip5;
    }

    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = (string) $state;
    }

    public function isResidential()
    {
        return $this->isResidential;
    }

    /**
     * @param boolean $isResidential
     */
    public function setIsResidential($isResidential)
    {
        $this->isResidential = (bool) $isResidential;
    }

    public function getView()
    {
        return new View\ShippingRate($this);
    }
}
