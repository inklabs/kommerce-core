<?php
namespace inklabs\kommerce\Entity;

class Price
{
    public $orig_unit_price;
    public $unit_price;
    public $orig_quantity_price;
    public $quantity_price;

    private $catalogPromotions = [];
    private $productQuantityDiscounts = [];

    public function addCatalogPromotion(CatalogPromotion $catalogPromotion)
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
    }

    public function addProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount)
    {
        $this->productQuantityDiscounts[] = $productQuantityDiscount;
    }

    public function getProductQuantityDiscounts()
    {
        return $this->productQuantityDiscounts;
    }

    public function getView()
    {
        return new View\Price($this);
    }
}
