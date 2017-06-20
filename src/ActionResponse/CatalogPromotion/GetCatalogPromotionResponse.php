<?php
namespace inklabs\kommerce\ActionResponse\CatalogPromotion;

use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;
use inklabs\kommerce\EntityDTO\CatalogPromotionDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetCatalogPromotionResponse implements ResponseInterface
{
    /** @var CatalogPromotionDTOBuilder */
    protected $catalogPromotionDTOBuilder;

    public function getCatalogPromotionDTO(): CatalogPromotionDTO
    {
        return $this->catalogPromotionDTOBuilder
            ->build();
    }

    public function getCatalogPromotionDTOWithAllData(): CatalogPromotionDTO
    {
        return $this->catalogPromotionDTOBuilder
            ->withAllData()
            ->build();
    }

    public function setCatalogPromotionDTOBuilder(CatalogPromotionDTOBuilder $catalogPromotionDTOBuilder): void
    {
        $this->catalogPromotionDTOBuilder = $catalogPromotionDTOBuilder;
    }
}
