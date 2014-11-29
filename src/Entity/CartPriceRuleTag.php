<?php
namespace inklabs\kommerce\Entity;

class CartPriceRuleTag extends CartPriceRuleItem
{
    protected $tag;

    public function __construct(Tag $tag, $quantity)
    {
        $this->setCreated();
        $this->tag = $tag;
        $this->quantity = $quantity;
    }

    public function matches(CartItem $cartItem)
    {
        foreach ($cartItem->getProduct()->getTags() as $tag) {
            if (
                ($tag->getId() === $this->tag->getId())
                and ($cartItem->getQuantity() >= $this->quantity)
            ) {
                return true;
            }
        }

        return false;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
    }
}
