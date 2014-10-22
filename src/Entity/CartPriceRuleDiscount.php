<?php
namespace inklabs\kommerce\Entity;

class CartPriceRuleDiscount
{
    use Accessor\Time;

    protected $id;
    protected $product;
    protected $quantity;

    public function __construct(Product $product = null, $quantity = null)
    {
        $this->setCreated();
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
