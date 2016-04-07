<?php
namespace inklabs\kommerce\EntityDTO;

class PriceDTO
{
    /** @var int */
    public $origUnitPrice;

    /** @var int */
    public $unitPrice;

    /** @var int */
    public $origQuantityPrice;

    /** @var int */
    public $quantityPrice;

    /** @var CatalogPromotionDTO[] */
    public $catalogPromotions = [];

    /* @var ProductQuantityDiscountDTO */
    public $productQuantityDiscounts = [];
}
