<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;

class CatalogPromotion extends AbstractService
{
    /** @var EntityRepository\CatalogPromotionInterface */
    private $catalogPromotionRepository;

    public function __construct(EntityRepository\CatalogPromotionInterface $catalogPromotionRepository)
    {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
    }

    public function create(Entity\CatalogPromotion & $catalogPromotion)
    {
        $this->throwValidationErrors($catalogPromotion);
        $this->catalogPromotionRepository->create($catalogPromotion);
    }

    public function edit(Entity\CatalogPromotion & $catalogPromotion)
    {
        $this->throwValidationErrors($catalogPromotion);
        $this->catalogPromotionRepository->save($catalogPromotion);
    }

    /**
     * @param int $id
     * @return Entity\CatalogPromotion|null
     */
    public function find($id)
    {
        return $this->catalogPromotionRepository->find($id);
    }

    /**
     * @return Entity\CatalogPromotion[]
     */
    public function findAll()
    {
        return $this->catalogPromotionRepository->findAll();
    }

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return Entity\CatalogPromotion[]
     */
    public function getAllCatalogPromotions($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->catalogPromotionRepository->getAllCatalogPromotions($queryString, $pagination);
    }

    /**
     * @param int[] $catalogPromotionIds
     * @param Entity\Pagination $pagination
     * @return Entity\CatalogPromotion[]
     */
    public function getAllCatalogPromotionsByIds($catalogPromotionIds, Entity\Pagination & $pagination = null)
    {
        return $this->catalogPromotionRepository->getAllCatalogPromotionsByIds($catalogPromotionIds, $pagination);
    }
}
