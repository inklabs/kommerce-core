<?php
namespace inklabs\kommerce\Entity;

class CartPriceRuleDiscount
{
	public $product;
	public $quantity;

	public function __construct(Product $product, $quantity)
	{
		$this->product = $product;
		$this->quantity = $quantity;
	}
}
