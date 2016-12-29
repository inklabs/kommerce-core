<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface CatalogPromotionServiceInterface
{
    /**
     * @param UuidInterface $id
     * @return CatalogPromotion
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);

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
