<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\Entity;

class FakeRepositoryCartPriceRule extends AbstractFakeRepository implements CartPriceRuleRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\CartPriceRule);
    }

    public function save(Entity\CartPriceRule & $cartPriceRule)
    {
    }

    public function create(Entity\CartPriceRule & $cartPriceRule)
    {
    }

    public function remove(Entity\CartPriceRule & $cartPriceRule)
    {
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findAll()
    {
        return $this->getReturnValueAsArray();
    }
}
