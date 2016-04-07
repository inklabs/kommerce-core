<?php
namespace inklabs\kommerce\EntityDTO;

class CartTotalDTO
{
    /** @var int */
    public $origSubtotal;

    /** @var int */
    public $subtotal;

    /** @var int */
    public $taxSubtotal;

    /** @var int */
    public $discount;

    /** @var int */
    public $shipping;

    /** @var int */
    public $shippingDiscount;

    /** @var int */
    public $tax;

    /** @var int */
    public $total;

    /** @var int */
    public $savings;

    /** @var CouponDTO[] */
    public $coupons = [];

    /** @var CartPriceRuleDTO[] */
    public $cartPriceRules = [];

    /** @var TaxRateDTO */
    public $taxRate;
}
