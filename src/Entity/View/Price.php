<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class Price
{
    public $origUnitPrice;
    public $unitPrice;
    public $origQuantityPrice;
    public $quantityPrice;
    public $catalogPromotions = [];
    public $productQuantityDiscounts = [];

    public function __construct(Entity\Price $price)
    {
        $this->price = $price;

        $this->origUnitPrice      = $price->origUnitPrice;
        $this->unitPrice          = $price->unitPrice;
        $this->origQuantityPrice  = $price->origQuantityPrice;
        $this->quantityPrice      = $price->quantityPrice;

        return $this;
    }

    public static function factory(Entity\Price $price)
    {
        return new static($price);
    }

    public function export()
    {
        unset($this->price);
        return $this;
    }

    public function withCatalogPromotions()
    {
        foreach ($this->price->getCatalogPromotions() as $catalogPromotion) {
            $this->catalogPromotions[] = CatalogPromotion::factory($catalogPromotion)
                ->export();
        }

        return $this;
    }

    public function withProductQuantityDiscounts()
    {
        foreach ($this->price->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $this->productQuantityDiscounts[] = ProductQuantityDiscount::factory($productQuantityDiscount)
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
