<?php
namespace inklabs\kommerce\Entity;

class Price
{
    public $orig_unit_price;
    public $unit_price;
    public $orig_quantity_price;
    public $quantity_price;

    private $catalogPromotions = [];
    private $quantityDiscounts = [];

    public function addCatalogPromotion(CatalogPromotion $catalogPromotion)
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
    }

    public function addQuantityDiscount(ProductQuantityDiscount $quantityDiscount)
    {
        $this->quantityDiscounts[] = $quantityDiscount;
    }

    public function getQuantityDiscounts()
    {
        return $this->quantityDiscounts;
    }

    public function getView()
    {
        return new View\Price($this);
    }
}
