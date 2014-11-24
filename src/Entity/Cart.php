<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use Exception;

class Cart
{
    protected $items = [];
    protected $coupons = [];
    protected $cartPriceRules = [];

    public function addItem(Product $product, $quantity)
    {
        $this->items[] = new CartItem($product, $quantity);

        end($this->items);
        $cartItemId = key($this->items);

        $this->items[$cartItemId]->setId($cartItemId);

        return $cartItemId;
    }

    public function getItem($id)
    {
        if (isset($this->items[$id])) {
            return $this->items[$id];
        } else {
            return null;
        }
    }

    public function getItems()
    {
        return $this->items;
    }

    public function deleteItem($id)
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
        } else {
            throw new \Exception('Item missing');
        }
    }

    public function getCoupons()
    {
        return $this->coupons;
    }

    public function updateCoupon($id, Coupon $coupon)
    {
        $this->coupons[$id] = $coupon;
    }

    public function addCoupon(Coupon $coupon)
    {
        if (! $this->canAddCoupon($coupon)) {
            throw new Exception('Unable to add coupon');
        }

        $this->coupons[] = $coupon;
    }

    private function canAddCoupon(Coupon $addedCoupon)
    {
        if ($addedCoupon->getCanCombineWithOtherCoupons()) {
            return true;
        }

        foreach ($this->coupons as $coupon) {
            if (! $coupon->getCanCombineWithOtherCoupons()) {
                return false;
            }
        }

        return true;
    }

    public function addCartPriceRule(CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRules[] = $cartPriceRule;
    }

    public function totalItems()
    {
        return count($this->items);
    }

    public function totalQuantity()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getQuantity();
        }

        return $total;
    }

    public function getShippingWeight()
    {
        $shippingWeight = 0;

        foreach ($this->items as $item) {
            $shippingWeight += $item->getShippingWeight();
        }

        return $shippingWeight;
    }

    public function getTotal(Pricing $pricing, Shipping\Rate $shippingRate = null, TaxRate $taxRate = null)
    {
        $this->pricing = $pricing;

        $this->cartTotal = new CartTotal;

        $this->calculateItemPrices();
        $this->calculateCartPriceRules();
        $this->calculateShippingPrice($shippingRate);
        $this->calculateCouponDiscounts();
        $this->calculateTaxes($taxRate);

        $this->calculateTotal();
        $this->calculateSavings();

        unset($this->pricing);

        return $this->cartTotal;
    }

    private function calculateItemPrices()
    {
        foreach ($this->items as $item) {
            $price = $item->getPrice($this->pricing);

            $this->cartTotal->origSubtotal += $price->origQuantityPrice;
            $this->cartTotal->subtotal += $price->quantityPrice;

            if ($item->getProduct()->getIsTaxable()) {
                $this->cartTotal->taxSubtotal += $price->quantityPrice;
            }
        }
    }

    private function calculateCartPriceRules()
    {
        foreach ($this->cartPriceRules as $cartPriceRule) {
            if ($cartPriceRule->isValid($this->pricing->getDate(), $this->cartTotal, $this->items)) {
                foreach ($cartPriceRule->getDiscounts() as $discount) {
                    $price = $this->pricing->getPrice($discount->getProduct(), $discount->getQuantity());

                    $this->cartTotal->subtotal -= $price->quantityPrice;

                    if ($cartPriceRule->getReducesTaxSubtotal() and $discount->getProduct()->getIsTaxable()) {
                        $this->cartTotal->taxSubtotal -= $price->quantityPrice;
                    }

                    $this->cartTotal->cartPriceRules[] = $cartPriceRule;
                }
            }
        }

        // No subtotal below zero!
        $this->cartTotal->subtotal = max(0, $this->cartTotal->subtotal);
    }

    private function calculateCouponDiscounts()
    {
        foreach ($this->coupons as $coupon) {
            if ($coupon->isValid($this->pricing->getDate(), $this->cartTotal->subtotal)) {
                $newSubtotal = $coupon->getUnitPrice($this->cartTotal->subtotal);
                $discountValue = $this->cartTotal->subtotal - $newSubtotal;
                $this->cartTotal->discount += $discountValue;
                $this->cartTotal->coupons[] = $coupon;

                if ($coupon->getReducesTaxSubtotal()) {
                    $this->cartTotal->taxSubtotal -= $discountValue;
                }

                if ($coupon->getFlagFreeShipping()) {
                    $this->cartTotal->shippingDiscount = $this->cartTotal->shipping;
                    $this->cartTotal->discount += $this->cartTotal->shipping;
                }
            }
        }

        // No taxes below zero!
        $this->cartTotal->taxSubtotal = max(0, $this->cartTotal->taxSubtotal);
    }

    private function calculateShippingPrice(Shipping\Rate $shippingRate = null)
    {
        if ($shippingRate !== null) {
            $this->cartTotal->shipping = $shippingRate->cost;
        }
    }

    private function calculateTaxes(TaxRate $taxRate = null)
    {
        if ($taxRate !== null) {
            $this->cartTotal->tax = $taxRate->getTax(
                $this->cartTotal->taxSubtotal,
                ($this->cartTotal->shipping - $this->cartTotal->shippingDiscount)
            );

            if ($this->cartTotal->tax > 0) {
                $this->cartTotal->taxRate = $taxRate;
            }
        }
    }

    private function calculateTotal()
    {
        $this->cartTotal->total = (
            $this->cartTotal->subtotal
            - $this->cartTotal->discount
            + $this->cartTotal->shipping
            + $this->cartTotal->tax
        );

        // No total below zero!
        $this->cartTotal->total = max(0, $this->cartTotal->total);
    }

    private function calculateSavings()
    {
        $this->cartTotal->savings = (
            $this->cartTotal->origSubtotal
            - $this->cartTotal->subtotal
            + $this->cartTotal->discount
        );
    }
}
