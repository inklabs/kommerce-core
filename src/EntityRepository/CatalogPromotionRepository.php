<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class CatalogPromotionRepository extends AbstractRepository implements CatalogPromotionRepositoryInterface
{
    public function getAllCatalogPromotions($queryString = null, Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $catalogPromotions = $qb->select('catalog_promotion')
            ->from('kommerce:CatalogPromotion', 'catalog_promotion');

        if ($queryString !== null) {
            $catalogPromotions = $catalogPromotions
                ->where('catalog_promotion.name LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        $catalogPromotions = $catalogPromotions
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $catalogPromotions;
    }

    public function getAllCatalogPromotionsByIds($catalogPromotionIds, Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $catalogPromotions = $qb->select('catalog_promotion')
            ->from('kommerce:CatalogPromotion', 'catalog_promotion')
            ->where('catalog_promotion.id IN (:catalogPromotionIds)')
            ->setParameter('catalogPromotionIds', $catalogPromotionIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $catalogPromotions;
    }
}
