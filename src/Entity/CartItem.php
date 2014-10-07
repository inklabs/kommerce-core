<?php
namespace inklabs\kommerce\Entity;

class CartItem
{
	use Accessors;

	public $product;
	public $product_options = [];
	public $quantity;

	public function __construct(Product $product, $quantity)
	{
		$this->product = $product;
		$this->quantity = $quantity;
	}
}
