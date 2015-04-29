<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service;
use inklabs\kommerce\View;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OptionValue implements EntityInterface
{
    use Accessor\Time, Accessor\Id;

    /** @var string */
    protected $sku;

    /** @var string */
    protected $name;

    /** @var int */
    protected $unitPrice;

    /** @var int */
    protected $shippingWeight;

    /** @var int */
    protected $sortOrder;

    /** @var Option */
    protected $option;

    public function __construct()
    {
        $this->setCreated();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @param int $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = (int) $unitPrice;
    }

    /**
     * @param int $quantity
     * @return Price
     */
    public function getPrice($quantity = 1)
    {
        $price = new Price;
        $price->origUnitPrice = $this->getUnitPrice();
        $price->origQuantityPrice = ($price->origUnitPrice * $quantity);
        $price->unitPrice = $price->origUnitPrice;
        $price->quantityPrice = $price->origQuantityPrice;

        return $price;
    }

    public function getUnitPrice()
    {
        return $this->unitPrice;
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

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setOption(Option $option)
    {
        $this->option = $option;
    }

    public function getOption()
    {
        return $this->option;
    }

    public function getView()
    {
        return new View\OptionValue($this);
    }
}
