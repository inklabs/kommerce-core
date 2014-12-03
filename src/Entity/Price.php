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
}
