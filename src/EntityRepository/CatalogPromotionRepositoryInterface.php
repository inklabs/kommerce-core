<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Pagination;

/**
 * @method CatalogPromotion findOneById($id)
 */
interface CatalogPromotionRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @return CatalogPromotion[]
     */
    public function findAll();

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return CatalogPromotion[]
     */
    public function getAllCatalogPromotions($queryString = null, Pagination & $pagination = null);

    /**
     * @param int[] $catalogPromotionIds
     * @param Pagination $pagination
     * @return CatalogPromotion[]
     */
    public function getAllCatalogPromotionsByIds($catalogPromotionIds, Pagination & $pagination = null);
}
