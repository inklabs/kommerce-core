<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\CartPriceRule;

class Pricing
{
    public $date;

    private $catalog_promotions = [];
    private $price;

    public function __construct(\DateTime $date = null)
    {
        if ($date === null) {
            $this->date = new \DateTime('now', new \DateTimeZone('UTC'));
        } else {
            $this->date = $date;
        }
    }

    public function addCatalogPromotion(CatalogPromotion $catalog_promotion)
    {
        $this->catalog_promotions[] = $catalog_promotion;
    }

    public function getPrice(Product $product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;

        $this->price = new Price;
        $this->price->orig_unit_price = $this->product->getPrice();
        $this->price->orig_quantity_price = ($this->price->orig_unit_price * $this->quantity);
        $this->price->unit_price = $this->price->orig_unit_price;

        $this->applyProductQuantityDiscounts();
        $this->applyCatalogPromotions();
        $this->calculateQuantityPrice();
        $this->applyProductOptionPrices();

        return $this->price;
    }

    private function applyProductQuantityDiscounts()
    {
        foreach ($this->product->getQuantityDiscounts() as $quantityDiscount) {
            if ($quantityDiscount->isValid($this->date, $this->quantity)) {
                $this->price->unit_price = $quantityDiscount->getUnitPrice($this->price->unit_price);
                $this->price->addQuantityDiscount($quantityDiscount);
                break;
            }
        }

        // No prices below zero!
        $this->price->unit_price = max(0, $this->price->unit_price);
    }

    private function applyCatalogPromotions()
    {
        foreach ($this->catalog_promotions as $catalog_promotion) {
            if ($catalog_promotion->isValid($this->date, $this->product)) {
                $this->price->unit_price = $catalog_promotion->getUnitPrice($this->price->unit_price);
                $this->price->addCatalogPromotion($catalog_promotion);
            }
        }

        // No prices below zero!
        $this->price->unit_price = max(0, $this->price->unit_price);
    }

    private function calculateQuantityPrice()
    {
        $this->price->quantity_price = ($this->price->unit_price * $this->quantity);
    }

    private function applyProductOptionPrices()
    {
        foreach ($this->product->selected_option_products as $option_product) {
            $sub_pricing = new Pricing($this->date);
            $option_product_price = $sub_pricing->getPrice($option_product, $this->quantity);

            $this->price->unit_price          += $option_product_price->unit_price;
            $this->price->orig_unit_price     += $option_product_price->orig_unit_price;
            $this->price->orig_quantity_price += $option_product_price->orig_quantity_price;
            $this->price->quantity_price      += $option_product_price->quantity_price;
        }
    }
}
