<?php
namespace inklabs\kommerce\EntityDTO;

class PriceDTO
{
    public $origUnitPrice;
    public $unitPrice;
    public $origQuantityPrice;
    public $quantityPrice;

    /** @var CatalogPromotionDTO[] */
    public $catalogPromotions = [];

    /* @var ProductQuantityDiscountDTO */
    public $productQuantityDiscounts = [];
}
