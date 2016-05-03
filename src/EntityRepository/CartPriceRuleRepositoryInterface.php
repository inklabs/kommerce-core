<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CartPriceRule;

/**
 * @method CartPriceRule findOneById($id)
 */
interface CartPriceRuleRepositoryInterface extends RepositoryInterface
{
    /**
     * @return CartPriceRule[]
     */
    public function findAll();
}
