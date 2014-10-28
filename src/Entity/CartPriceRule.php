<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class CartPriceRule extends Promotion
{
    protected $items;
    protected $discounts;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->discounts = new ArrayCollection();
    }

    public function addItem(CartPriceRuleItem $item)
    {
        $this->items[] = $item;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function addDiscount(CartPriceRuleDiscount $discount)
    {
        $this->discounts[] = $discount;
    }

    public function getDiscounts()
    {
        return $this->discounts;
    }

    public function isValid(\DateTime $date, CartTotal $cartTotal, array $cartItems)
    {
        return $this->isValidPromotion($date)
            and $this->isCartItemsValid($cartItems);
    }

    public function isCartItemsValid(array $cartItems)
    {
        $matchedItemsCount = 0;
        foreach ($this->items as $item) {
            foreach ($cartItems as $cartItem) {
                if ($cartItem->getProduct() == $item->getProduct()
                    and $cartItem->getQuantity() >= $item->getQuantity()
                ) {
                    $matchedItemsCount++;
                    break;
                }
            }
        }

        if ($matchedItemsCount == count($this->items)) {
            return true;
        } else {
            return false;
        }
    }
}
