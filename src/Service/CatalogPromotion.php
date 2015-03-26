<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\EntityRepository as EntityRepository;
use Doctrine\ORM\EntityManager;

class CatalogPromotion extends Lib\ServiceManager
{
    /** @var EntityRepository\CatalogPromotion */
    private $catalogPromotionRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->catalogPromotionRepository = $entityManager->getRepository('kommerce:CatalogPromotion');
    }

    /* @return Entity\View\CatalogPromotion */
    public function find($id)
    {
        /** @var Entity\CatalogPromotion $entityCatalogPromotion */
        $entityCatalogPromotion = $this->entityManager->getRepository('kommerce:CatalogPromotion')->find($id);

        if ($entityCatalogPromotion === null) {
            return null;
        }

        return $entityCatalogPromotion->getView()
            ->export();
    }

    /* @return Entity\CatalogPromotion[] */
    public function findAll()
    {
        return $this->entityManager->getRepository('kommerce:CatalogPromotion')->findAll();
    }

    public function getAllCatalogPromotions($queryString = null, Entity\Pagination & $pagination = null)
    {
        $catalogPromotions = $this->catalogPromotionRepository
            ->getAllCatalogPromotions($queryString, $pagination);

        return $this->getViewCatalogPromotions($catalogPromotions);
    }

    public function getAllCatalogPromotionsByIds($catalogPromotionIds, Entity\Pagination & $pagination = null)
    {
        $catalogPromotions = $this->catalogPromotionRepository
            ->getAllCatalogPromotionsByIds($catalogPromotionIds);

        return $this->getViewCatalogPromotions($catalogPromotions);
    }

    /**
     * @param Entity\CatalogPromotion[] $catalogPromotions
     * @return Entity\View\CatalogPromotion[]
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
