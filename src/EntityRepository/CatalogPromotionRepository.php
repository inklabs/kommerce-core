<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Pagination;

class CatalogPromotionRepository extends AbstractRepository implements CatalogPromotionRepositoryInterface
{
    public function getAllCatalogPromotions(string $queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('CatalogPromotion')
            ->from(CatalogPromotion::class, 'CatalogPromotion');

        if (trim($queryString) !== '') {
            $query
                ->where('CatalogPromotion.name LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getAllCatalogPromotionsByIds(array $catalogPromotionIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('CatalogPromotion')
            ->from(CatalogPromotion::class, 'CatalogPromotion')
            ->where('CatalogPromotion.id IN (:catalogPromotionIds)')
            ->setIdParameter('catalogPromotionIds', $catalogPromotionIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
