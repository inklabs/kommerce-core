<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

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

    public function getName()
    {
        return $this->product->getName();
    }

    public function getSku()
    {
        return $this->product->getSku();
    }

    public function getShippingWeight()
    {
        return $this->getProduct()->getShippingWeight();
    }

    /**
     * @param PricingInterface $pricing
     * @param int $quantity
     * @return Price
     */
    public function getPrice(PricingInterface $pricing, $quantity = 1)
    {
        return $this->getProduct()->getPrice($pricing, $quantity);
    }

    public function getProduct()
    {
        return $this->product;
    }
}
