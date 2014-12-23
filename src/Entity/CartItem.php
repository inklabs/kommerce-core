<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;

class CartItem
{
    use Accessor\Created;

    protected $id;
    protected $product;
    protected $quantity;

    public function __construct(Product $product, $quantity)
    {
        $this->setCreated();
        $this->product = $product;
        $this->quantity = (int) $quantity;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    public function getPrice(Pricing $pricing)
    {
        return $pricing->getPrice(
            $this->product,
            $this->quantity
        );
    }

    public function getShippingWeight()
    {
        return ($this->product->getShippingWeight() * $this->quantity);
    }

    public function getView()
    {
        return new View\CartItem($this);
    }
}
