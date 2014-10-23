<?php
namespace inklabs\kommerce\Entity\View;

class Price
{
    private $price;

    public $orig_unit_price;
    public $unit_price;
    public $orig_quantity_price;
    public $quantity_price;
    public $catalogPromotions = [];
    public $productQuantityDiscounts = [];

    public function __construct($price)
    {
        $this->price = $price;

        $this->orig_unit_price     = $price->orig_unit_price;
        $this->unit_price          = $price->unit_price;
        $this->orig_quantity_price = $price->orig_quantity_price;
        $this->quantity_price      = $price->quantity_price;

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
