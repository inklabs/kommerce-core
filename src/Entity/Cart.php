<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Pricing;

class Cart
{
    use Accessors;

    public $items = [];
    public $coupons = [];
    public $cart_price_rules = [];
    public $tax_rate;

    private $cart_total;
    private $pricing;
    private $shipping_rate;

    public function addItem(Product $product, $quantity)
    {
        $this->items[] = new CartItem($product, $quantity);
    }

    public function addCoupon(Coupon $coupon)
    {
        $this->coupons[] = $coupon;
    }

    public function addCartPriceRule(CartPriceRule $cart_price_rule)
    {
        $this->cart_price_rules[] = $cart_price_rule;
    }

    public function setTaxRate(TaxRate $tax_rate)
    {
        $this->tax_rate = $tax_rate;
    }

    public function totalItems()
    {
        return count($this->items);
    }

    public function totalQuantity()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->quantity;
        }

        return $total;
    }

    public function getTotal(Pricing $pricing, Shipping\Rate $shipping_rate = null)
    {
        $this->cart_total = new CartTotal;
        $this->pricing = $pricing;
        $this->shipping_rate = $shipping_rate;

        $this->getItemPrices();
        $this->getCartPriceRules();
        $this->getCouponDiscounts();
        $this->getShippingPrice();
        $this->getTaxes();

        $this->calculateTotal();
        $this->calculateSavings();

        return $this->cart_total;
    }

    private function getItemPrices()
    {
        foreach ($this->items as $item) {
            $price = $this->pricing->getPrice($item->product, $item->quantity);

            $this->cart_total->orig_subtotal += $price->orig_quantity_price;
            $this->cart_total->subtotal += $price->quantity_price;

            if ($item->product->getIsTaxable()) {
                $this->cart_total->tax_subtotal += $price->quantity_price;
            }
        }
    }

    private function getCartPriceRules()
    {
        foreach ($this->cart_price_rules as $cart_price_rule) {
            if ($cart_price_rule->isValid($this->pricing->date, $this->cart_total, $this->items)) {
                foreach ($cart_price_rule->discounts as $discount) {
                    $price = $this->pricing->getPrice($discount->product, $discount->quantity);

                    $this->cart_total->subtotal -= $price->quantity_price;

                    if ($cart_price_rule->reducesTaxSubtotal() and $discount->product->getIsTaxable()) {
                        $this->cart_total->tax_subtotal -= $price->quantity_price;
                    }

                    $this->cart_total->cart_price_rules[] = $cart_price_rule;
                }
            }
        }

        // No subtotal below zero!
        $this->cart_total->subtotal = max(0, $this->cart_total->subtotal);
    }

    private function getCouponDiscounts()
    {
        foreach ($this->coupons as $coupon) {
            if ($coupon->isValid($this->pricing->date, $this->cart_total->subtotal)) {
                $new_subtotal = $coupon->getUnitPrice($this->cart_total->subtotal);
                $discount_value = $this->cart_total->subtotal - $new_subtotal;
                $this->cart_total->discount += $discount_value;
                $this->cart_total->coupons[] = $coupon;

                if ($coupon->reducesTaxSubtotal()) {
                    $this->cart_total->tax_subtotal -= $discount_value;
                }
            }
        }

        // No taxes below zero!
        $this->cart_total->tax_subtotal = max(0, $this->cart_total->tax_subtotal);
    }

    private function getShippingPrice()
    {
        if ($this->shipping_rate !== null) {
            $this->cart_total->shipping = $this->shipping_rate->cost;
        }
    }

    private function getTaxes()
    {
        if ($this->tax_rate !== null) {
            $this->cart_total->tax = $this->tax_rate->getTax(
                $this->cart_total->tax_subtotal,
                $this->cart_total->shipping
            );

            if ($this->cart_total->tax > 0) {
                $this->cart_total->tax_rate = $this->tax_rate;
            }
        }
    }

    private function calculateTotal()
    {
        $this->cart_total->total = (
            $this->cart_total->subtotal
            - $this->cart_total->discount
            + $this->cart_total->shipping
            - $this->cart_total->shipping_discount
            + $this->cart_total->tax
        );

        // No total below zero!
        $this->cart_total->total = max(0, $this->cart_total->total);
    }

    private function calculateSavings()
    {
        $this->cart_total->savings = (
            $this->cart_total->orig_subtotal
            - $this->cart_total->subtotal
            + $this->cart_total->discount
            + $this->cart_total->shipping_discount
        );
    }
}
