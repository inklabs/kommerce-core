<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class CatalogPromotionRepository extends AbstractRepository implements CatalogPromotionRepositoryInterface
{
    public function getAllCatalogPromotions($queryString = null, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('catalog_promotion')
            ->from('kommerce:CatalogPromotion', 'catalog_promotion');

        if ($queryString !== null) {
            $query
                ->where('catalog_promotion.name LIKE :query')
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
            ->select('catalog_promotion')
            ->from('kommerce:CatalogPromotion', 'catalog_promotion')
            ->where('catalog_promotion.id IN (:catalogPromotionIds)')
            ->setParameter('catalogPromotionIds', $catalogPromotionIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
