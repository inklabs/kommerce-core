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

    public function add_item(Product $product, $quantity)
    {
        $this->items[] = new CartItem($product, $quantity);
    }

    public function add_coupon(Coupon $coupon)
    {
        $this->coupons[] = $coupon;
    }

    public function add_cart_price_rule(CartPriceRule $cart_price_rule)
    {
        $this->cart_price_rules[] = $cart_price_rule;
    }

    public function set_tax_rate(TaxRate $tax_rate)
    {
        $this->tax_rate = $tax_rate;
    }

    public function total_items()
    {
        return count($this->items);
    }

    public function total_quantity()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->quantity;
        }

        return $total;
    }

    public function get_total(Pricing $pricing, Shipping\Rate $shipping_rate = NULL)
    {
        $cart_total = new CartTotal;

        // Get item prices
        foreach ($this->items as $item) {
            $price = $pricing->get_price($item->product, $item->quantity);

            $cart_total->orig_subtotal += $price->orig_quantity_price;
            $cart_total->subtotal += $price->quantity_price;

            if ($item->product->is_taxable) {
                $cart_total->tax_subtotal += $price->quantity_price;
            }
        }

        foreach ($this->cart_price_rules as $cart_price_rule) {
            if ($cart_price_rule->is_valid($pricing->date, $cart_total, $this->items)) {
                foreach ($cart_price_rule->discounts as $discount) {
                    $price = $pricing->get_price($discount->product, $discount->quantity);

                    $cart_total->subtotal -= $price->quantity_price;

                    if ($cart_price_rule->reduces_tax_subtotal AND $discount->product->is_taxable) {
                        $cart_total->tax_subtotal -= $price->quantity_price;
                    }

                    $cart_total->cart_price_rules[] = $cart_price_rule;
                }
            }
        }

        // No subtotal below zero after cart price rules!
        $cart_total->subtotal = max(0, $cart_total->subtotal);

        // Get coupon discounts
        foreach ($this->coupons as $coupon) {
            if ($coupon->is_valid($pricing->date, $cart_total->subtotal)) {
                $new_subtotal = $coupon->get_unit_price($cart_total->subtotal);
                $discount_value = $cart_total->subtotal - $new_subtotal;
                $cart_total->discount += $discount_value;
                $cart_total->coupons[] = $coupon;

                if ($coupon->reduces_tax_subtotal) {
                    $cart_total->tax_subtotal -= $discount_value;
                }
            }
        }

        // No taxes below zero!
        $cart_total->tax_subtotal = max(0, $cart_total->tax_subtotal);

        if ($shipping_rate !== NULL) {
            $cart_total->shipping = $shipping_rate->cost;
        }

        // Get taxes
        if ($this->tax_rate !== NULL) {
            $cart_total->tax = $this->tax_rate->get_tax(
                $cart_total->tax_subtotal,
                $cart_total->shipping
            );

            if ($cart_total->tax > 0) {
                $cart_total->tax_rate = $this->tax_rate;
            }
        }

        $cart_total->total = (
            $cart_total->subtotal
            - $cart_total->discount
            + $cart_total->shipping
            - $cart_total->shipping_discount
            + $cart_total->tax
        );

        $cart_total->savings = (
            $cart_total->orig_subtotal
            - $cart_total->subtotal
            + $cart_total->discount
            + $cart_total->shipping_discount
        );

        // No total below zero!
        $cart_total->total = max(0, $cart_total->total);

        return $cart_total;
    }
}
