<?php
namespace inklabs\kommerce\ActionResponse\CatalogPromotion;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\CatalogPromotionDTO;

class ListCatalogPromotionsResponse
{
    /** @var CatalogPromotionDTOBuilder[] */
    private $catalogPromotionDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    private $paginationDTOBuilder;

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder)
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    public function addCatalogPromotionDTOBuilder(CatalogPromotionDTOBuilder $catalogPromotionDTOBuilder)
    {
        $this->catalogPromotionDTOBuilders[] = $catalogPromotionDTOBuilder;
    }

    /**
     * @return CatalogPromotionDTO[]
     */
    public function getCatalogPromotionDTOs()
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
    public function getCatalogPromotionDTOsWithAllData()
    {
        $catalogPromotionDTOs = [];
        foreach ($this->catalogPromotionDTOBuilders as $catalogPromotionDTOBuilder) {
            $catalogPromotionDTOs[] = $catalogPromotionDTOBuilder
                ->withAllData()
                ->build();
        }
        return $catalogPromotionDTOs;
    }

    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO()
    {
        return $this->paginationDTOBuilder->build();
    }
}
