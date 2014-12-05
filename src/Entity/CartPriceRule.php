<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class CartPriceRule extends Promotion
{
    /* @var CartPriceRule\Item[] */
    protected $items;

    /* @var CartPriceRuleDiscount */
    protected $discounts;

    public function __construct()
    {
        parent::__construct();
        $this->items = new ArrayCollection();
        $this->discounts = new ArrayCollection();
    }

    public function addItem(CartPriceRule\Item $item)
    {
        $item->setCartPriceRule($this);
        $this->items[] = $item;
    }

    /**
     * @return CartPriceRule\Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    public function addDiscount(CartPriceRuleDiscount $discount)
    {
        $discount->setCartPriceRule($this);
        $this->discounts[] = $discount;
    }

    public function getDiscounts()
    {
        return $this->discounts;
    }

    public function isValid(\DateTime $date, array $cartItems)
    {
        return $this->isValidPromotion($date)
            and $this->isCartItemsValid($cartItems);
    }

    public function isCartItemsValid(array $cartItems)
    {
        $matchedItemsCount = 0;
        foreach ($this->items as $item) {
            foreach ($cartItems as $cartItem) {
                if ($item->matches($cartItem)) {
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
