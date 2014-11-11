<?php
namespace inklabs\kommerce\Entity;

class CartTotal
{
    public $origSubtotal = 0;      // Used to calculate total savings
    public $subtotal = 0;          // Subtotal after catalog promotions
    public $taxSubtotal = 0;       // Total used for tax calculation
    public $discount = 0;          // Coupons and cart price rules
    public $shipping = null;
    public $shippingDiscount = 0; // Coupons and cart price rules (separate from $discount)
    public $tax = 0;
    public $total = 0;
    public $savings = 0;
    public $coupons = [];
    public $cartPriceRules = [];
    public $taxRate;
}
