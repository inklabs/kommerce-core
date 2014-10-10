<?php
namespace inklabs\kommerce\Entity;

class Promotion
{
	public $discount_type; // fixed, percent, exact
	public $value;
	public $redemptions;
	public $max_redemptions;
	public $start;
	public $end;

	// Must define: public function is_valid(...){}

	public function is_date_valid(\DateTime $date)
	{
		$current_date_ts = $date->getTimestamp();

		if ($current_date_ts >= $this->start->getTimestamp() AND $current_date_ts <= $this->end->getTimestamp()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function is_redemption_count_valid()
	{
		if ($this->max_redemptions !== NULL AND $this->redemptions >= $this->max_redemptions) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function get_price($unit_price)
	{
		switch ($this->discount_type) {
			case 'fixed':
				return (int) ($unit_price - $this->value);
				break;

			case 'percent':
				return (int) ($unit_price - ($unit_price * ($this->value / 100)));
				break;

			case 'exact':
				return (int) $this->value;
				break;
		}
	}
}
