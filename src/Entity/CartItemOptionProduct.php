<?php
namespace inklabs\kommerce\Entity;

class CartItemOptionProduct
{
    use Accessor\Created;

    protected $id;

    /* @var Option */
    protected $option;

    /* @var Product */
    protected $product;

    public function __construct(Option $option, Product $product)
    {
        $this->setCreated();

        $this->setOption($option);
        $this->setProduct($product);
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getOption()
    {
        return $this->option;
    }

    public function setOption(Option $option)
    {
        $this->option = $option;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getView()
    {
        return new View\CartItemOptionProduct($this);
    }
}
