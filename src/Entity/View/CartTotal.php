<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CartTotal
{
    public $origSubtotal;
    public $subtotal;
    public $taxSubtotal;
    public $discount;
    public $shipping;
    public $shippingDiscount;
    public $tax;
    public $total;
    public $savings;

    /** @var Coupon[] */
    public $coupons = [];

    /** @var CartPriceRule[] */
    public $cartPriceRules = [];

    /** @var TaxRate */
    public $taxRate;

    public function __construct(Entity\CartTotal $cartTotal)
    {
        $this->cartTotal = $cartTotal;

        $this->origSubtotal     = $cartTotal->origSubtotal;
        $this->subtotal         = $cartTotal->subtotal;
        $this->taxSubtotal      = $cartTotal->taxSubtotal;
        $this->discount         = $cartTotal->discount;
        $this->shipping         = $cartTotal->shipping;
        $this->shippingDiscount = $cartTotal->shippingDiscount;
        $this->tax              = $cartTotal->tax;
        $this->total            = $cartTotal->total;
        $this->savings          = $cartTotal->savings;
    }

    public function export()
    {
        unset($this->cartTotal);
        return $this;
    }

    public function withCoupons()
    {
        foreach ($this->cartTotal->coupons as $key => $coupon) {
            $this->coupons[$key] = $coupon->getView()
                ->export();
        }

        return $this;
    }

    public function withCartPriceRules()
    {
        foreach ($this->cartTotal->cartPriceRules as $key => $cartPriceRule) {
            $this->cartPriceRules[$key] = $cartPriceRule->getView()
                ->export();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withCoupons()
            ->withCartPriceRules();
    }
}
