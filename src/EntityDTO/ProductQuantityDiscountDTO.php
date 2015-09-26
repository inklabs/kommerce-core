<?php
namespace inklabs\kommerce\EntityDTO;

class ProductQuantityDiscountDTO extends AbstractPromotionDTO
{
    public $customerGroup;
    public $flagApplyCatalogPromotions;
    public $quantity;

    /** @var ProductDTO */
    public $product;

    /** @var PriceDTO */
    public $price;
}
