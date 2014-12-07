<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class CartPriceRule extends Promotion
{
    /* @var CartPriceRuleItem\Item[] */
    protected $items;

    /* @var CartPriceRuleDiscount[] */
    protected $cartPriceRuleDiscounts;

    public function __construct()
    {
        parent::__construct();
        $this->items = new ArrayCollection();
        $this->cartPriceRuleDiscounts = new ArrayCollection();
    }

    public function addItem(CartPriceRuleItem\Item $item)
    {
        $item->setCartPriceRule($this);
        $this->items[] = $item;
    }

    /**
     * @return CartPriceRuleItem\Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    public function addDiscount(CartPriceRuleDiscount $discount)
    {
        $discount->setCartPriceRule($this);
        $this->cartPriceRuleDiscounts[] = $discount;
    }

    /**
     * @return CartPriceRuleDiscount[]
     */
    public function getCartPriceRuleDiscounts()
    {
        return $this->cartPriceRuleDiscounts;
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
