<?php
namespace inklabs\kommerce\Entity;

class Pricing
{
    public $date;

    private $catalogPromotions = [];
    private $price;

    public function __construct(\DateTime $date = null)
    {
        if ($date === null) {
            $this->date = new \DateTime('now', new \DateTimeZone('UTC'));
        } else {
            $this->date = $date;
        }
    }

    public function addCatalogPromotion(CatalogPromotion $catalogPromotion)
    {
        $this->catalogPromotions[] = $catalogPromotion;
    }

    public function addCatalogPromotions(array $catalogPromotions)
    {
        foreach ($catalogPromotions as $catalogPromotion) {
            $this->addCatalogPromotion($catalogPromotion);
        }
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
                $this->price->addProductQuantityDiscount($quantityDiscount);
                break;
            }
        }

        // No prices below zero!
        $this->price->unit_price = max(0, $this->price->unit_price);
    }

    private function applyCatalogPromotions()
    {
        foreach ($this->catalogPromotions as $catalogPromotion) {
            if ($catalogPromotion->isValid($this->date, $this->product)) {
                $this->price->unit_price = $catalogPromotion->getUnitPrice($this->price->unit_price);
                $this->price->addCatalogPromotion($catalogPromotion);
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
        foreach ($this->product->getSelectedOptionProducts() as $option_product) {
            $sub_pricing = new Pricing($this->date);
            $option_product_price = $sub_pricing->getPrice($option_product, $this->quantity);

            $this->price->unit_price          += $option_product_price->unit_price;
            $this->price->orig_unit_price     += $option_product_price->orig_unit_price;
            $this->price->orig_quantity_price += $option_product_price->orig_quantity_price;
            $this->price->quantity_price      += $option_product_price->quantity_price;
        }
    }
}
