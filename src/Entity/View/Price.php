<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class Price
{
    public $origUnitPrice;
    public $unitPrice;
    public $origQuantityPrice;
    public $quantityPrice;

    /* @var CatalogPromotion[] */
    public $catalogPromotions = [];

    /* @var ProductQuantityDiscount */
    public $productQuantityDiscount;

    public function __construct(Entity\Price $price)
    {
        $this->price = $price;

        $this->origUnitPrice      = $price->origUnitPrice;
        $this->unitPrice          = $price->unitPrice;
        $this->origQuantityPrice  = $price->origQuantityPrice;
        $this->quantityPrice      = $price->quantityPrice;
    }

    public function export()
    {
        unset($this->price);
        return $this;
    }

    public function withCatalogPromotions()
    {
        foreach ($this->price->getCatalogPromotions() as $catalogPromotion) {
            $this->catalogPromotions[] = $catalogPromotion->getView()
                ->export();
        }

        return $this;
    }

    public function withProductQuantityDiscounts()
    {
        foreach ($this->price->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $this->productQuantityDiscounts[] = $productQuantityDiscount->getView()
                ->export();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withCatalogPromotions()
            ->withProductQuantityDiscounts();
    }
}
