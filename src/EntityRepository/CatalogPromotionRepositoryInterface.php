<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface CatalogPromotionRepositoryInterface
{
    public function save(Entity\CatalogPromotion & $catalogPromotion);
    public function create(Entity\CatalogPromotion & $catalogPromotion);
    public function remove(Entity\CatalogPromotion & $catalogPromotion);

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
