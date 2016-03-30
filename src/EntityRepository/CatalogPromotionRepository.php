<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Pagination;

class CatalogPromotionRepository extends AbstractRepository implements CatalogPromotionRepositoryInterface
{
    public function getAllCatalogPromotions($queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('CatalogPromotion')
            ->from(CatalogPromotion::class, 'CatalogPromotion');

        if ($queryString !== null) {
            $query
                ->where('CatalogPromotion.name LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getAllCatalogPromotionsByIds($catalogPromotionIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('CatalogPromotion')
            ->from(CatalogPromotion::class, 'CatalogPromotion')
            ->where('CatalogPromotion.id IN (:catalogPromotionIds)')
            ->setParameter('catalogPromotionIds', $catalogPromotionIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
