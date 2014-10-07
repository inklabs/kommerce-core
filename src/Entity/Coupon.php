<?php
namespace inklabs\kommerce\Entity;

class Coupon
{
	use Accessors;

	public $id;
	public $code;
	public $name;
	public $tag;
	public $discount_type;
	public $discount_value;
	public $free_shipping;
	public $min_order_value;
	public $max_order_value;
	public $redemptions;
	public $max_redemptions;
	public $start;
	public $end;
	public $created;
}
