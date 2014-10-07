<?php
namespace inklabs\kommerce\Entity;

class TaxRate
{
	use Accessors;

	public $id;
	public $state;
	public $zip5;
	public $zip5_from;
	public $zip5_to;
	public $rate = 0.0;
	public $apply_to_shipping;
	public $created;
	public $updated;

	public function get_tax(CartTotal $cart_total)
	{
		$tax_subtotal = $cart_total->subtotal - $cart_total->discount;

		if ($this->apply_to_shipping) {
			$tax_subtotal += $cart_total->shipping;
		}

		return (int) round($tax_subtotal * ($this->rate / 100));
	}
}
