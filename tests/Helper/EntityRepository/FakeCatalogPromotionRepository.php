<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;

/**
 * @method CatalogPromotion findOneById($id)
 */
class FakeCatalogPromotionRepository extends AbstractFakeRepository implements CatalogPromotionRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new CatalogPromotion);
    }

    public function findAll()
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllCatalogPromotions($queryString = null, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllCatalogPromotionsByIds($catalogPromotionIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
