<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OptionValue implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string|null */
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

    public function __construct(Option $option, UuidInterface $id = null)
    {
        $this->setId($id);
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setUnitPrice(int $unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    public function getPrice(int $quantity = 1): Price
    {
        $price = new Price;
        $price->origUnitPrice = $this->getUnitPrice();
        $price->origQuantityPrice = ($price->origUnitPrice * $quantity);
        $price->unitPrice = $price->origUnitPrice;
        $price->quantityPrice = $price->origQuantityPrice;

        return $price;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku)
    {
        $this->sku = $sku;
    }

    public function getShippingWeight(): int
    {
        return $this->shippingWeight;
    }

    public function setShippingWeight(int $shippingWeight)
    {
        $this->shippingWeight = $shippingWeight;
    }

    public function setSortOrder(int $sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function getOption(): Option
    {
        return $this->option;
    }
}
