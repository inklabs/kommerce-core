<?php
namespace inklabs\kommerce\EntityDTO;

class CartTotalDTO
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

    /** @var CouponDTO[] */
    public $coupons = [];

    /** @var CartPriceRuleDTO[] */
    public $cartPriceRules = [];

    /** @var TaxRateDTO */
    public $taxRate;
}
