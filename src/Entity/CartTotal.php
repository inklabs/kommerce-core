<?php
namespace inklabs\kommerce\Entity;

class CartTotal
{
    /** @var int */
    public $origSubtotal = 0;

    /** @var int */
    public $subtotal = 0;

    /** @var int */
    public $taxSubtotal = 0;

    /** @var int */
    public $discount = 0;

    /** @var int */
    public $shipping = 0;

    /** @var int */
    public $shippingDiscount = 0;

    /** @var int */
    public $tax = 0;

    /** @var int */
    public $total = 0;

    /** @var int */
    public $savings = 0;

    /** @var Coupon[] */
    public $coupons = [];

    /** @var CartPriceRule[] */
    public $cartPriceRules = [];

    /** @var TaxRate */
    public $taxRate;

    public function getView()
    {
        return new View\CartTotal($this);
    }
}
