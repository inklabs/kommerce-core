<?php
namespace inklabs\kommerce\EntityDTO;

class ProductQuantityDiscountDTO extends AbstractPromotionDTO
{
    public $customerGroup;

    /** @var bool */
    public $flagApplyCatalogPromotions;

    /** @var int */
    public $quantity;

    /** @var ProductDTO */
    public $product;

    /** @var PriceDTO */
    public $price;
}
