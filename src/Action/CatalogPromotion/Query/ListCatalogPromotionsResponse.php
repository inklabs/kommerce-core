<?php
namespace inklabs\kommerce\Action\CatalogPromotion\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\CatalogPromotionDTO;

class ListCatalogPromotionsResponse implements ListCatalogPromotionsResponseInterface
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
     * @return PaginationDTO
     */
    public function getPaginationDTO()
    {
        return $this->paginationDTOBuilder->build();
    }
}
