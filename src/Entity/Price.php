<?php
namespace inklabs\kommerce\Entity;

class Price
{
    public $orig_unit_price;
    public $unit_price;
    public $orig_quantity_price;
    public $quantity_price;

    private $catalogPromotions = [];
    private $quantity_discounts = [];

    public function addCatalogPromotion(CatalogPromotion $catalogPromotion)
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    public function addQuantityDiscount(ProductQuantityDiscount $quantityDiscount)
    {
        $this->quantityDiscounts[] = $quantityDiscount;
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

        $class->catalogPromotions = [];
        foreach ($this->catalogPromotions as $catalogPromotion) {
            $class->catalogPromotions[] = $catalogPromotion->getAllData();
        }

        return $class;
    }
}
