<?php
namespace inklabs\kommerce\Entity;

class CartPriceRule extends Promotion
{
    public $name;
    private $items = [];
    public $discounts = [];

    public function addItem(CartPriceRuleItem $item)
    {
        $this->items[] = $item;
    }

    public function addDiscount(CartPriceRuleDiscount $discount)
    {
        $this->discounts[] = $discount;
    }

    public function isValid(\DateTime $date, CartTotal $cart_total, array $cart_items)
    {
        return parent::isValid($date)
            and $this->isCartTotalValid($cart_total)
            and $this->isCartItemsValid($cart_items);
    }

    public function isCartTotalValid(CartTotal $cart_total)
    {
        // TODO: Add support for cart_total_valid
        return true;
    }

    public function isCartItemsValid(array $cart_items)
    {
        $matched_items_count = 0;
        foreach ($this->items as $item) {
            foreach ($cart_items as $cart_item) {
                if ($cart_item->product->id == $item->product->id and $cart_item->quantity >= $item->quantity) {
                    $matched_items_count++;
                    break;
                }
            }
        }

        if ($matched_items_count == count($this->items)) {
            return true;
        } else {
            return false;
        }
    }
}
