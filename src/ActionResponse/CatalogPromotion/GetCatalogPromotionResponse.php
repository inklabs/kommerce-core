<?php
namespace inklabs\kommerce\ActionResponse\CatalogPromotion;

use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;

class GetCatalogPromotionResponse
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
