<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemDTO
{
    public $id;
    public $quantity;
    public $sku;
    public $name;
    public $discountNames;
    public $created;
    public $updated;

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
