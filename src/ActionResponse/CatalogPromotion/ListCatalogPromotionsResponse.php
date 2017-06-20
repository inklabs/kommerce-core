<?php
namespace inklabs\kommerce\ActionResponse\CatalogPromotion;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\CatalogPromotionDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListCatalogPromotionsResponse implements ResponseInterface
{
    /** @var CatalogPromotionDTOBuilder[] */
    private $catalogPromotionDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    private $paginationDTOBuilder;

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    public function addCatalogPromotionDTOBuilder(CatalogPromotionDTOBuilder $catalogPromotionDTOBuilder): void
    {
        $this->catalogPromotionDTOBuilders[] = $catalogPromotionDTOBuilder;
    }

    /**
     * @return CatalogPromotionDTO[]
     */
    public function getCatalogPromotionDTOs(): array
    {
        $catalogPromotionDTOs = [];
        foreach ($this->catalogPromotionDTOBuilders as $catalogPromotionDTOBuilder) {
            $catalogPromotionDTOs[] = $catalogPromotionDTOBuilder->build();
        }
        return $catalogPromotionDTOs;
    }

    /**
     * @return CatalogPromotionDTO[]
     */
    public function getCatalogPromotionDTOsWithAllData(): array
    {
        $catalogPromotionDTOs = [];
        foreach ($this->catalogPromotionDTOBuilders as $catalogPromotionDTOBuilder) {
            $catalogPromotionDTOs[] = $catalogPromotionDTOBuilder
                ->withAllData()
                ->build();
        }
        return $catalogPromotionDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTOBuilder->build();
    }
}
