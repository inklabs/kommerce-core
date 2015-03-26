<?php
namespace inklabs\kommerce\Entity;

class OptionValue
{
    use Accessor\Time, Accessor\Id;

    /** @var int */
    protected $sortOrder;

    /** @var Product */
    protected $product;

    /** @var Option */
    protected $option;

    public function __construct()
    {
        $this->setCreated();
        $this->sortOrder = 0;
    }

    public function getName()
    {
        if ($this->getProduct() === null) {
            return null;
        }

        return $this->getProduct()->getName();
    }

    public function getSku()
    {
        if ($this->getProduct() === null) {
            return null;
        }

        return $this->getProduct()->getSku();
    }

    public function getShippingWeight()
    {
        if ($this->getProduct() === null) {
            return null;
        }

        return $this->getProduct()->getShippingWeight();
    }

    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getOption()
    {
        return $this->option;
    }

    public function setOption(Option $option)
    {
        $this->option = $option;
    }

    public function getView()
    {
        return new View\OptionValue($this);
    }
}
