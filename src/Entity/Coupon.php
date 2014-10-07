<?php
namespace inklabs\kommerce\Entity;

class Coupon extends Promotion
{
	use Accessors;

	public $id;
	public $code;
	public $name;
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

	public function is_valid(\DateTime $date)
	{
		return $this->is_date_valid($date)
			AND $this->is_redemption_count_valid();
	}
}
