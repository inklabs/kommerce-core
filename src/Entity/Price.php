<?php
namespace inklabs\kommerce\Entity;

class Price
{
    public $origUnitPrice;
    public $unitPrice;
    public $origQuantityPrice;
    public $quantityPrice;

    /* @var CatalogPromotion[] */
    private $catalogPromotions = [];

    /* @var ProductQuantityDiscount */
    private $productQuantityDiscount;

    public function addCatalogPromotion(CatalogPromotion $catalogPromotion)
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    /**
     * @return CatalogPromotion[]
     */
    public function getCatalogPromotions()
    {
        return $this->catalogPromotions;
    }

    public function setProductQuantityDiscount(ProductQuantityDiscount $productQuantityDiscount)
    {
        $this->productQuantityDiscount = $productQuantityDiscount;
    }

    /**
     * @return ProductQuantityDiscount
     */
    public function getProductQuantityDiscount()
    {
        return $this->productQuantityDiscount;
    }

    public static function add(Price $a, Price $b)
    {
        $price = new Price;
        $price->unitPrice         = $a->unitPrice         + $b->unitPrice;
        $price->origUnitPrice     = $a->origUnitPrice     + $b->origUnitPrice;
        $price->quantityPrice     = $a->quantityPrice     + $b->quantityPrice;
        $price->origQuantityPrice = $a->origQuantityPrice + $b->origQuantityPrice;

        return $price;
    }
}
