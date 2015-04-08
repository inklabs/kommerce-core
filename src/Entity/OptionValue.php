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

    public function __construct(Option $option)
    {
        $this->setCreated();
        $this->sortOrder = 0;

        $this->setOption($option);
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
        $product = $this->getProduct();
        if ($product === null) {
            return null;
        }

        return $product->getSku();
    }

    public function getShippingWeight()
    {
        $product = $this->getProduct();
        if ($product === null) {
            return null;
        }

        return $product->getShippingWeight();
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
        $product->addOptionValue($this);
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
        $option->addOptionValue($this);
        $this->option = $option;
    }

    public function getView()
    {
        return new View\OptionValue($this);
    }
}
