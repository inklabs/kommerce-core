<?php
namespace inklabs\kommerce\Entity\View;

class Price
{
    private $price;

    public $origUnitPrice;
    public $unitPrice;
    public $origQuantityPrice;
    public $quantityPrice;
    public $catalogPromotions = [];
    public $productQuantityDiscounts = [];

    public function __construct($price)
    {
        $this->price = $price;

        $this->origUnitPrice     = $price->origUnitPrice;
        $this->unitPrice          = $price->unitPrice;
        $this->origQuantityPrice = $price->origQuantityPrice;
        $this->quantityPrice      = $price->quantityPrice;

        return $this;
    }

    public function export()
    {
        unset($this->price);
        return $this;
    }

    public function withCatalogPromotions()
    {
        foreach ($this->price->getCatalogPromotions() as $catalogPromotion) {
            $this->catalogPromotions[] = $catalogPromotion
                ->getView()
                ->export();
        }

        return $this;
    }

    public function withProductQuantityDiscounts()
    {
        foreach ($this->price->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $this->productQuantityDiscounts[] = $productQuantityDiscount
                ->getView()
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
