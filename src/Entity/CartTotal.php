<?php
namespace inklabs\kommerce\Entity;

class CartTotal
{
    public $origSubtotal = 0;
    public $subtotal = 0;
    public $taxSubtotal = 0;
    public $discount = 0;
    public $shipping = 0;
    public $shippingDiscount = 0;
    public $tax = 0;
    public $total = 0;
    public $savings = 0;

    /* @var Coupon[] */
    public $coupons = [];

    /* @var CartPriceRule[] */
    public $cartPriceRules = [];

    /* @var TaxRate */
    public $taxRate;

    public function getView()
    {
        return new View\CartTotal($this);
    }
}
