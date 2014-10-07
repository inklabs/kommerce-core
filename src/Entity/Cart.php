<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Pricing;

class Cart
{
	use Accessors;

	public $items = [];

	public function add_item(Product $product, $quantity)
	{
		$this->items[] = new CartItem($product, $quantity);
	}

	public function total_items()
	{
		return count($this->items);
	}

	public function total_quantity()
	{
		$total = 0;

		foreach ($this->items as $item) {
			$total += $item->quantity;
		}

		return $total;
	}

	public function get_total(Pricing $pricing)
	{
		$cart_total = new CartTotal;

		foreach ($this->items as $item) {

			$price = $pricing->get_price($item->product, $item->quantity);

			$cart_total->orig_subtotal += $price->orig_quantity_price;
			$cart_total->subtotal += $price->quantity_price;

			// TODO: Get coupon discounts
			// TODO: Get shopping cart promotions
			// TODO: Get tax
			// TODO: Get shipping

			$cart_total->total = (
				$cart_total->subtotal
				- $cart_total->discount
				+ $cart_total->shipping
				- $cart_total->shipping_discount
				+ $cart_total->tax
			);

			$cart_total->savings = (
				$cart_total->orig_subtotal
				- $cart_total->subtotal
				+ $cart_total->discount
				+ $cart_total->shipping_discount
			);
		}

		return $cart_total;
	}
}
