<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method CatalogPromotion findOneById(UuidInterface $id)
 */
interface CatalogPromotionRepositoryInterface extends RepositoryInterface
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
     * @param UuidInterface[] $catalogPromotionIds
     * @param Pagination $pagination
     * @return CatalogPromotion[]
     */
    public function getAllCatalogPromotionsByIds(array $catalogPromotionIds, Pagination & $pagination = null);
}
