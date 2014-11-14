<?php
namespace inklabs\kommerce\Entity;

class CartItem
{
    use Accessor\Time;

    protected $id;
    protected $product;
    protected $quantity;

    public function __construct(Product $product, $quantity)
    {
        $this->setCreated();
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->setUpdated();
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPrice(\inklabs\kommerce\Service\Pricing $pricing)
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
}
