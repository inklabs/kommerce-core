<?php
namespace inklabs\kommerce\Entity\CartPriceRuleDiscount;

use inklabs\kommerce\Entity as Entity;

class Tag extends Discount
{
    /* @var Entity\Tag */
    protected $tag;

    public function __construct(Entity\Tag $tag, $quantity)
    {
        $this->setCreated();
        $this->tag = $tag;
        $this->quantity = $quantity;
    }

    /**
     * @return Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }
}
