<?php
namespace inklabs\kommerce\Entity;

class OrderItem
{
    use Accessor\Time;

    protected $id;
    protected $product;
    protected $quantity;
    protected $price;

    public function __construct(CartItem $cartItem, \inklabs\kommerce\Service\Pricing $pricing)
    {
        $this->product = $cartItem->getProduct();
        $this->quantity = $cartItem->getQuantity();
        $this->price = $cartItem->getPrice($pricing);
    }

    public function getPrice()
    {
        return $this->price;
    }
}
