<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class CartPriceRule extends AbstractEntityRepository implements CartPriceRuleInterface
{
    public function save(Entity\CartPriceRule & $cartPriceRule)
    {
        $this->saveEntity($cartPriceRule);
    }

    public function create(Entity\CartPriceRule & $cartPriceRule)
    {
        $this->createEntity($cartPriceRule);
    }

    public function remove(Entity\CartPriceRule & $cartPriceRule)
    {
        $this->removeEntity($cartPriceRule);
    }
}
