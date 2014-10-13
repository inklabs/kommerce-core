<?php
namespace inklabs\kommerce\Entity;

class Coupon extends Promotion
{
	use Accessors;

	public $id;
	public $code;
	public $name;
	public $free_shipping = FALSE;
	public $reduces_tax_subtotal = TRUE;
	public $min_order_value;
	public $max_order_value;
	public $created;

	public function is_valid(\DateTime $date, $subtotal)
	{
		return parent::is_valid($date)
			AND $this->is_min_order_value_valid($subtotal)
			AND $this->is_max_order_value_valid($subtotal);
	}

	public function is_min_order_value_valid($subtotal)
	{
		if ($this->min_order_value !== NULL AND $subtotal < $this->min_order_value) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function is_max_order_value_valid($subtotal)
	{
		if ($this->max_order_value !== NULL AND $subtotal > $this->max_order_value) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
}
