<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method CartPriceRule findOneById(UuidInterface $id)
 */
interface CartPriceRuleRepositoryInterface extends RepositoryInterface
{
    /**
     * @return CartPriceRule[]
     */
    public function findAll();

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return CartPriceRule[]
     */
    public function getAllCartPriceRules(string $queryString = null, Pagination & $pagination = null);
}
