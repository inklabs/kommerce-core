<?php
namespace inklabs\kommerce\Entity;

class CartPriceRule extends Promotion
{
	public $name;
	private $items = [];
	public $discounts = [];

	public function add_item(CartPriceRuleItem $item)
	{
		$this->items[] = $item;
	}

	public function add_discount(CartPriceRuleDiscount $discount)
	{
		$this->discounts[] = $discount;
	}

	public function is_valid(\DateTime $date, CartTotal $cart_total, array $cart_items)
	{
		return parent::is_valid($date)
			AND $this->cart_total_valid($cart_total)
			AND $this->cart_items_valid($cart_items);
	}

	public function cart_total_valid(CartTotal $cart_total)
	{
		// TODO: Add support for cart_total_valid
		return TRUE;
	}

	public function cart_items_valid(array $cart_items)
	{
		$matched_items_count = 0;
		foreach ($this->items as $item) {
			foreach ($cart_items as $cart_item) {
				if ($cart_item->product->id == $item->product->id AND $cart_item->quantity >= $item->quantity) {
					$matched_items_count++;
					break;
				}
			}
		}

		if ($matched_items_count == count($this->items)){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
