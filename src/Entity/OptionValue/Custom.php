<?php
namespace inklabs\kommerce\Entity\OptionValue;

use inklabs\kommerce\Service;
use inklabs\kommerce\View;
use inklabs\kommerce\Entity;

class Custom extends AbstractOptionValue implements OptionValueInterface
{
    /** @var string */
    protected $sku;

    /** @var string */
    protected $name;

    /** @var Entity\Price */
    protected $price;

    /** @var int */
    protected $shippingWeight;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function setPrice(Entity\Price $price)
    {
        $this->price = $price;
    }

    public function getPrice(Service\Pricing $pricing)
    {
        return $this->price;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = (string) $sku;
    }

    public function getShippingWeight()
    {
        return $this->shippingWeight;
    }

    public function setShippingWeight($shippingWeight)
    {
        $this->shippingWeight = (int) $shippingWeight;
    }

    public function getView()
    {
        return new View\OptionValue\Custom($this);
    }
}
