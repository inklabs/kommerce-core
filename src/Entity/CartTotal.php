<?php
namespace inklabs\kommerce\Entity;

class CartTotal
{
	use Accessors;

	public $orig_subtotal = 0;
	public $subtotal = 0;
	public $discount = 0;
	public $shipping = 0;
	public $shipping_discount = 0;
	public $tax = 0;
	public $total = 0;
	public $savings = 0;
}
