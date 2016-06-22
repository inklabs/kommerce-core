<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

class CatalogPromotionService implements CatalogPromotionServiceInterface
{
    use EntityValidationTrait;

    /** @var CatalogPromotionRepositoryInterface */
    private $catalogPromotionRepository;

    public function __construct(CatalogPromotionRepositoryInterface $catalogPromotionRepository)
    {
        $this->catalogPromotionRepository = $catalogPromotionRepository;
    }

    public function create(CatalogPromotion & $catalogPromotion)
    {
        $this->throwValidationErrors($catalogPromotion);
        $this->catalogPromotionRepository->create($catalogPromotion);
    }

    public function update(CatalogPromotion & $catalogPromotion)
    {
        $this->throwValidationErrors($catalogPromotion);
        $this->catalogPromotionRepository->update($catalogPromotion);
    }

    /**
     * @param UuidInterface $id
     * @return CatalogPromotion
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id)
    {
        return $this->catalogPromotionRepository->findOneById($id);
    }

    /**
     * @return CatalogPromotion[]
     */
    public function findAll()
    {
        return $this->catalogPromotionRepository->findAll();
    }

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return CatalogPromotion[]
     */
    public function getAllCatalogPromotions($queryString = null, Pagination & $pagination = null)
    {
        return $this->catalogPromotionRepository->getAllCatalogPromotions($queryString, $pagination);
    }

    /**
     * @param int[] $catalogPromotionIds
     * @param Pagination $pagination
     * @return CatalogPromotion[]
     */
    public function getAllCatalogPromotionsByIds($catalogPromotionIds, Pagination & $pagination = null)
    {
        return $this->catalogPromotionRepository->getAllCatalogPromotionsByIds($catalogPromotionIds, $pagination);
    }
}
