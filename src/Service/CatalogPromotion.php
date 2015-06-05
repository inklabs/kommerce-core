<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
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
     * @return View\CatalogPromotion|null
     */
    public function find($id)
    {
        $catalogPromotion = $this->catalogPromotionRepository->find($id);

        if ($catalogPromotion === null) {
            return null;
        }

        return $catalogPromotion->getView()
            ->export();
    }

    /**
     * @return View\CatalogPromotion[]
     */
    public function findAll()
    {
        $catalogPromotions = $this->catalogPromotionRepository->findAll();
        return $this->getViewCatalogPromotions($catalogPromotions);
    }

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return View\CatalogPromotion[]
     */
    public function getAllCatalogPromotions($queryString = null, Entity\Pagination & $pagination = null)
    {
        $catalogPromotions = $this->catalogPromotionRepository
            ->getAllCatalogPromotions($queryString, $pagination);

        return $this->getViewCatalogPromotions($catalogPromotions);
    }

    /**
     * @param int[] $catalogPromotionIds
     * @param Entity\Pagination $pagination
     * @return View\CatalogPromotion[]
     */
    public function getAllCatalogPromotionsByIds($catalogPromotionIds, Entity\Pagination & $pagination = null)
    {
        $catalogPromotions = $this->catalogPromotionRepository
            ->getAllCatalogPromotionsByIds($catalogPromotionIds, $pagination);

        return $this->getViewCatalogPromotions($catalogPromotions);
    }

    /**
     * @param Entity\CatalogPromotion[] $catalogPromotions
     * @return View\CatalogPromotion[]
     */
    private function getViewCatalogPromotions($catalogPromotions)
    {
        $viewCatalogPromotions = [];
        foreach ($catalogPromotions as $catalogPromotion) {
            $viewCatalogPromotions[] = $catalogPromotion->getView()
                ->export();
        }

        return $viewCatalogPromotions;
    }
}
