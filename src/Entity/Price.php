<?php
namespace inklabs\kommerce\Entity;

class Price
{
    public $origUnitPrice;
    public $unitPrice;
    public $origQuantityPrice;
    public $quantityPrice;

    private $catalogPromotions = [];
    private $productQuantityDiscount;

    public function addCatalogPromotion(CatalogPromotion $catalogPromotion)
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
    }

    public function setProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount)
    {
        $this->productQuantityDiscount = $productQuantityDiscount;
    }

    public function getProductQuantityDiscount()
    {
        return $this->productQuantityDiscount;
    }
}
