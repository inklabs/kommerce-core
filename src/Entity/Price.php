<?php
namespace inklabs\kommerce\Entity;

class Price
{
    use Accessors;

    public $orig_unit_price;
    public $unit_price;
    public $orig_quantity_price;
    public $quantity_price;

    private $catalog_promotions = [];
    private $quantity_discounts = [];

    public function addCatalogPromotion(CatalogPromotion $catalog_promotion)
    {
        $this->catalog_promotions[] = $catalog_promotion;
    }

    public function addQuantityDiscount(ProductQuantityDiscount $quantity_discount)
    {
        $this->quantity_discounts[] = $quantity_discount;
    }
}
