<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;

/**
 * @method CartPriceRule findOneById($id)
 */
class FakeCartPriceRuleRepository extends AbstractFakeRepository implements CartPriceRuleRepositoryInterface
{
    protected $entityName = 'CartPriceRule';

    public function __construct()
    {
        $this->setReturnValue(new CartPriceRule);
    }

    public function findAll()
    {
        return $this->getReturnValueAsArray();
    }
}
