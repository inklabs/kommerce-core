<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CatalogPromotionInterface
{
    /**
     * @param int $id
     * @return Entity\CatalogPromotion
     */
    public function find($id);

    /**
     * @return Entity\CatalogPromotion[]
     */
    public function findAll();

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return Entity\CatalogPromotion[]
     */
    public function getAllCatalogPromotions($queryString = null, Entity\Pagination & $pagination = null);

    /**
     * @param int[] $catalogPromotionIds
     * @param Entity\Pagination $pagination
     * @return Entity\CatalogPromotion[]
     */
    public function getAllCatalogPromotionsByIds($catalogPromotionIds, Entity\Pagination & $pagination = null);
}
