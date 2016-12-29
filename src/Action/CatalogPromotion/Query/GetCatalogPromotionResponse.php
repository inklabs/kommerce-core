<?php
namespace inklabs\kommerce\Action\CatalogPromotion\Query;

use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;

class GetCatalogPromotionResponse implements GetCatalogPromotionResponseInterface
{
    /** @var CatalogPromotionDTOBuilder */
    protected $catalogPromotionDTOBuilder;

    public function getCatalogPromotionDTO()
    {
        return $this->catalogPromotionDTOBuilder
            ->build();
    }

    public function getCatalogPromotionDTOWithAllData()
    {
        return $this->catalogPromotionDTOBuilder
            ->withAllData()
            ->build();
    }

    public function setCatalogPromotionDTOBuilder(CatalogPromotionDTOBuilder $catalogPromotionDTOBuilder)
    {
        $this->catalogPromotionDTOBuilder = $catalogPromotionDTOBuilder;
    }
}
