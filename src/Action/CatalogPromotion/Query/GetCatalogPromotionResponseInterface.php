<?php
namespace inklabs\kommerce\Action\CatalogPromotion\Query;

use inklabs\kommerce\EntityDTO\Builder\CatalogPromotionDTOBuilder;

interface GetCatalogPromotionResponseInterface
{
    public function setCatalogPromotionDTOBuilder(CatalogPromotionDTOBuilder $catalogPromotionDTOBuilder);
}
