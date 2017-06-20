<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;

class PricingCalculator
{
    /** @var Pricing */
    protected $pricing;

    /** @var Product */
    protected $product;

    /** @var Price */
    protected $price;

    protected $quantity;

    public function __construct(Pricing $pricing)
    {
        $this->pricing = $pricing;
    }

    public function getPrice(Product $product, $quantity): Price
    {
        $this->product = $product;
        $this->quantity = $quantity;

        $this->price = new Price();
        $this->price->origUnitPrice = $this->product->getUnitPrice();
        $this->price->origQuantityPrice = ($this->price->origUnitPrice * $this->quantity);
        $this->price->unitPrice = $this->price->origUnitPrice;

        $this->calculateProductQuantityDiscounts();
        $this->calculateCatalogPromotions();
        $this->calculateQuantityPrice();

        return $this->price;
    }

    private function calculateProductQuantityDiscounts(): void
    {
        foreach ($this->pricing->getProductQuantityDiscounts() as $productQuantityDiscount) {
            if ($productQuantityDiscount->isValid($this->pricing->getDate(), $this->quantity)) {
                $this->price->unitPrice = $productQuantityDiscount->getUnitPrice($this->price->unitPrice);
                $this->price->addProductQuantityDiscount($productQuantityDiscount);
                break;
            }
        }

        // No prices below zero!
        $this->price->unitPrice = max(0, $this->price->unitPrice);
    }

    private function calculateCatalogPromotions(): void
    {
        foreach ($this->pricing->getCatalogPromotions() as $catalogPromotion) {
            if ($catalogPromotion->isValid($this->pricing->getDate(), $this->product)) {
                $this->price->unitPrice = $catalogPromotion->getUnitPrice($this->price->unitPrice);
                $this->price->addCatalogPromotion($catalogPromotion);
            }
        }

        // No prices below zero!
        $this->price->unitPrice = max(0, $this->price->unitPrice);
    }

    private function calculateQuantityPrice(): void
    {
        $this->price->quantityPrice = ($this->price->unitPrice * $this->quantity);
    }
}
