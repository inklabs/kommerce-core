<?php
namespace inklabs\kommerce\Entity;

class CartTotal
{
	use Accessors;

	public $orig_subtotal = 0;     // Used to calculate total savings
	public $subtotal = 0;          // Subtotal after catalog promotions
	public $tax_subtotal = 0;      // Total used for tax calculation
	public $discount = 0;          // Coupons and cart price rules
	public $shipping = 0;
	public $shipping_discount = 0; // Coupons and cart price rules (separate from $discount)
	public $tax = 0;
	public $total = 0;
	public $savings = 0;
	public $coupons = [];
	public $cart_price_rules = [];
	public $tax_rate;
}
