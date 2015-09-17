<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class CartPriceRuleRepository extends AbstractRepository implements CartPriceRuleRepositoryInterface
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
