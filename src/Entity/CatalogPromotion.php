<?php
namespace inklabs\kommerce\Entity;

class CatalogPromotion
{
	use Accessors;

	public $id;
	public $code;
	public $name;
	public $tag;
	public $discount_type; // fixed/percent
	public $discount_value;
	public $free_shipping;
	public $redemptions;
	public $max_redemptions;
	public $start;
	public $end;
	public $created;

	public function is_valid(\DateTime $date, Product $product)
	{
		return $this->is_date_valid($date)
			AND $this->is_redemption_count_valid()
			AND $this->is_tag_valid($product);
	}

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

	public function is_tag_valid(Product $product)
	{
		if ($this->tag !== NULL) {
			foreach ($product->tags as $tag) {
				if ($tag->id == $this->tag->id) {
					return TRUE;
				}
			}

			return FALSE;
		}

		return TRUE;
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
