<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CartPriceRule;

/**
 * @method CartPriceRule find($id)
 */
interface CartPriceRuleRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @return CartPriceRule[]
     */
    public function findAll();
}
