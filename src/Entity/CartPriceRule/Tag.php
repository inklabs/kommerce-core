<?php
namespace inklabs\kommerce\Entity\CartPriceRule;

use inklabs\kommerce\Entity as Entity;

class Tag extends Item
{
    /* @var Entity\Tag */
    protected $tag;

    public function __construct(Entity\Tag $tag, $quantity)
    {
        $this->setCreated();
        $this->tag = $tag;
        $this->quantity = $quantity;
    }

    public function matches(Entity\CartItem $cartItem)
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

    /**
     * @return Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }
}
