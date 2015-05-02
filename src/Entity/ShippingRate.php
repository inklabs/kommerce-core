<?php
namespace inklabs\kommerce\Entity;

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
}
