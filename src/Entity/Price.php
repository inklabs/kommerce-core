<?php
namespace inklabs\kommerce\Entity;

class Price
{
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

    public function getData()
    {
        $class = new \stdClass;
        $class->orig_unit_price = $this->orig_unit_price;
        $class->unit_price = $this->unit_price;
        $class->orig_quantity_price = $this->orig_quantity_price;
        $class->quantity_price = $this->quantity_price;

        return $class;
    }

    public function getAllData()
    {
        $class = $this->getData();

        $class->catalog_promotions = [];
        foreach ($this->catalog_promotions as $catalogPromotion) {
            $class->catalog_promotions[] = $catalogPromotion->getAllData();
        }

        return $class;
    }
}
