<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var int */
    public $quantity;

    /** @var string */
    public $sku;

    /** @var string */
    public $name;

    /** @var string */
    public $discountNames;

    /** @var int */
    public $shippingWeight;

    /** @var PriceDTO */
    public $price;

    /** @var ProductDTO */
    public $product;

    /** @var OrderItemOptionProductDTO[] */
    public $orderItemOptionProducts = [];

    /** @var OrderItemOptionValueDTO[] */
    public $orderItemOptionValues = [];

    /** @var OrderItemTextOptionValueDTO[] */
    public $orderItemTextOptionValues = [];

    /** @var CatalogPromotionDTO[] */
    public $catalogPromotions = [];

    /** @var ProductQuantityDiscountDTO[] */
    public $productQuantityDiscounts = [];
}
