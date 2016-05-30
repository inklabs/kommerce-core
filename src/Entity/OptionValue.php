<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OptionValueDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OptionValue implements IdEntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

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

    public function __construct(Option $option)
    {
        $this->setId();
        $this->setCreated();
        $this->option = $option;
        $option->addOptionValue($this);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank);
        $metadata->addPropertyConstraint('name', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('sku', new Assert\Length([
            'max' => 64,
        ]));

        $metadata->addPropertyConstraint('unitPrice', new Assert\NotNull);
        $metadata->addPropertyConstraint('unitPrice', new Assert\Range([
            'min' => 0,
            'max' => 4294967295,
        ]));

        $metadata->addPropertyConstraint('shippingWeight', new Assert\NotNull);
        $metadata->addPropertyConstraint('shippingWeight', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
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

    /**
     * @param int $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = (int) $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function getOption()
    {
        return $this->option;
    }

    public function getDTOBuilder()
    {
        return new OptionValueDTOBuilder($this);
    }
}
