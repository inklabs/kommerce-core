<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\CatalogPromotionInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class FakeCatalogPromotion extends Helper\AbstractFake implements CatalogPromotionInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\CatalogPromotion);
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
