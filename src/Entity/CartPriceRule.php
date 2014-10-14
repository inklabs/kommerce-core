<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class CartPriceRule extends Promotion
{
    private $items;
    public $discounts;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->discounts = new ArrayCollection();
    }

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
        return $this->isValidPromotion($date)
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
                if ($cart_item->getProduct() == $item->getProduct()
                    and $cart_item->getQuantity() >= $item->getQuantity()
                ) {
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
