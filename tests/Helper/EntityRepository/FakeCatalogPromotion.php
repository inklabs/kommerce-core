<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\CatalogPromotionInterface;
use inklabs\kommerce\Entity;

class FakeCatalogPromotion extends AbstractFake implements CatalogPromotionInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\CatalogPromotion);
    }

    public function save(Entity\CatalogPromotion & $catalogPromotion)
    {
    }

    public function create(Entity\CatalogPromotion & $catalogPromotion)
    {
    }

    public function remove(Entity\CatalogPromotion & $catalogPromotion)
    {
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findAll()
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllCatalogPromotions($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllCatalogPromotionsByIds($catalogPromotionIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
