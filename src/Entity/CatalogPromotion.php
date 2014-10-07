<?php
namespace inklabs\kommerce\Entity;

class CatalogPromotion extends Promotion
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
}
