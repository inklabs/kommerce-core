<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface CartPriceRuleServiceInterface
{
    /**
     * @param UuidInterface $id
     * @return CartPriceRule
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);

    /**
     * @return CartPriceRule[]
     */
    public function findAll();

    /**
     * @param null|string $queryString
     * @param null|Pagination $pagination
     * @return CartPriceRule[]
     */
    public function getAllCartPriceRules($queryString = null, Pagination & $pagination = null);
}
