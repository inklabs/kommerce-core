<?php
namespace inklabs\kommerce\ActionResponse\CatalogPromotion;

use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetCatalogPromotionResponse implements ResponseInterface
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
