<?php
namespace inklabs\kommerce\Entity;

class Price
{
    public $origUnitPrice;
    public $unitPrice;
    public $origQuantityPrice;
    public $quantityPrice;

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
}
