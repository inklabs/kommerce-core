<?php
namespace inklabs\kommerce\Action\CatalogPromotion\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;

interface ListCatalogPromotionsResponseInterface
{
    public function setPaginationDTOBuilder(PaginationDTOBuilder$paginationDTOBuilder);
    public function addCatalogPromotionDTOBuilder(CatalogPromotionDTOBuilder $catalogPromotionDTOBuilder);
}
