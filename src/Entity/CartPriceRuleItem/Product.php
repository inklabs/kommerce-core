<?php
namespace inklabs\kommerce\Entity\CartPriceRuleItem;

use inklabs\kommerce\Entity as Entity;

class Product extends Item
{
    /* @var Entity\Product */
    protected $product;

    public function __construct(Entity\Product $product, $quantity)
    {
        $this->setCreated();
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function matches(Entity\CartItem $cartItem)
    {
        if (
            $cartItem->getProduct()->getId() == $this->product->getId()
            and $cartItem->getQuantity() >= $this->quantity
        ) {
            return true;
        }

        return false;
    }

    /**
     * @return Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
