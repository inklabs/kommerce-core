<?php
namespace inklabs\kommerce\Entity;

class Promotion
{
	public function is_date_valid(\DateTime $date)
	{
		$current_date_ts = $date->getTimestamp();

		if ($current_date_ts >= $this->start->getTimestamp() OR $current_date_ts <= $this->end->getTimestamp()) {
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

	public function get_discount_value($price)
	{
		if ($this->discount_type == 'fixed') {
			return (int) $this->discount_value;
		} elseif ($this->discount_type == 'percent') {
			return (int) ($price * ($this->discount_value) / 100);
		}
	}
}
