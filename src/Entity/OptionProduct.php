<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class OptionProduct implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var int */
    protected $sortOrder;

    /** @var Product */
    protected $product;

    /** @var Option */
    protected $option;

    public function __construct(Option $option, Product $product, UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->option = $option;
        $this->product = $product;
        $option->addOptionProduct($this);
        $product->addOptionProduct($this);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
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

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function getSku(): string
    {
        return $this->product->getSku();
    }

    public function getShippingWeight(): int
    {
        return $this->getProduct()->getShippingWeight();
    }

    public function getPrice(PricingInterface $pricing, int $quantity = 1): Price
    {
        return $this->getProduct()->getPrice($pricing, $quantity);
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}
