<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\Pagination;

class CartPriceRuleRepository extends AbstractRepository implements CartPriceRuleRepositoryInterface
{
    public function getAllCartPriceRules($queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('CartPriceRule')
            ->from(CartPriceRule::class, 'CartPriceRule');

        if (trim($queryString) !== '') {
            $query
                ->orWhere('CartPriceRule.name LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
