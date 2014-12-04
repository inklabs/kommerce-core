<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class PricingCalculator
{
    /* @var Pricing */
    protected $pricing;

    /* @var Entity\Product */
    protected $product;

    /* @var Entity\Price */
    protected $price;

    protected $quantity;

    public function __construct(Pricing $pricing)
    {
        $this->pricing = $pricing;
    }

    public function getPrice(Entity\Product $product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;

        $this->price = new Entity\Price;
        $this->price->origUnitPrice = $this->product->getUnitPrice();
        $this->price->origQuantityPrice = ($this->price->origUnitPrice * $this->quantity);
        $this->price->unitPrice = $this->price->origUnitPrice;

        $this->calculateProductQuantityDiscounts();
        $this->calculateCatalogPromotions();
        $this->calculateQuantityPrice();
        $this->calculateProductOptionPrices();

        return $this->price;
    }

    private function calculateProductQuantityDiscounts()
    {
        foreach ($this->pricing->getProductQuantityDiscounts() as $productQuantityDiscount) {
            if ($productQuantityDiscount->isValid($this->pricing->getDate(), $this->quantity)) {
                $this->price->unitPrice = $productQuantityDiscount->getUnitPrice($this->price->unitPrice);
                $this->price->setProductQuantityDiscount($productQuantityDiscount);
                break;
            }
        }

        // No prices below zero!
        $this->price->unitPrice = max(0, $this->price->unitPrice);
    }

    private function calculateCatalogPromotions()
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

    private function calculateQuantityPrice()
    {
        $this->price->quantityPrice = ($this->price->unitPrice * $this->quantity);
    }

    private function calculateProductOptionPrices()
    {
        foreach ($this->product->getProducts() as $optionProduct) {
            $subPricing = new Pricing($this->pricing->getDate());
            $optionProductPrice = $optionProduct->getPrice($subPricing, $this->quantity);

            $this->price = Entity\Price::add($this->price, $optionProductPrice);
        }
    }
}
