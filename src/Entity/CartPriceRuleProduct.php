<?php
namespace inklabs\kommerce\Entity;

class CartPriceRuleProduct extends CartPriceRuleItem
{
    protected $product;

    public function __construct(Product $product, $quantity)
    {
        $this->setCreated();
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function matches(CartItem $cartItem)
    {
        if (
            $cartItem->getProduct()->getId() == $this->product->getId()
            and $cartItem->getQuantity() >= $this->quantity
        ) {
            return true;
        }

        return false;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
}
