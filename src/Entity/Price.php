<?php
namespace inklabs\kommerce\Entity;

class Price
{
	use Accessors;

	public $orig_unit_price;
	public $unit_price;
	public $orig_quantity_price;
	public $quantity_price;
	public $catalog_promotions = [];
}
