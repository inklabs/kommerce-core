<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OptionProductDTOBuilder;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class OptionProduct implements ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var int */
    protected $sortOrder;

    /** @var Product */
    protected $product;

    /** @var Option */
    protected $option;

    public function __construct()
    {
        $this->setCreated();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
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

    public function getName()
    {
        return $this->getProduct()->getName();
    }

    public function getSku()
    {
        return $this->getProduct()->getSku();
    }

    public function getShippingWeight()
    {
        return $this->getProduct()->getShippingWeight();
    }

    /**
     * @param Lib\PricingInterface $pricing
     * @param int $quantity
     * @return Price
     */
    public function getPrice(Lib\PricingInterface $pricing, $quantity = 1)
    {
        return $this->getProduct()->getPrice($pricing, $quantity);
    }

    public function setProduct(Product $product)
    {
        $product->addOptionProduct($this);
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getView()
    {
        return new View\OptionProduct($this);
    }

    public function getDTOBuilder()
    {
        return new OptionProductDTOBuilder($this);
    }
}
