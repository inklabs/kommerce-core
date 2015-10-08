<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;

class FakeCartPriceRuleRepository extends AbstractFakeRepository implements CartPriceRuleRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new CartPriceRule);
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
