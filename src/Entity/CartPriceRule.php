<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CartPriceRule extends AbstractPromotion
{
    /** @var CartPriceRuleProductItem[]|CartPriceRuleTagItem[] */
    protected $cartPriceRuleItems;

    /** @var CartPriceRuleDiscount[] */
    protected $cartPriceRuleDiscounts;

    public function __construct()
    {
        parent::__construct();
        $this->cartPriceRuleItems = new ArrayCollection;
        $this->cartPriceRuleDiscounts = new ArrayCollection;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);
    }

    public function addItem(AbstractCartPriceRuleItem $item)
    {
        $item->setCartPriceRule($this);
        $this->cartPriceRuleItems[] = $item;
    }

    /**
     * @return AbstractCartPriceRuleItem[]
     */
    public function getCartPriceRuleItems()
    {
        return $this->cartPriceRuleItems;
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

    public function isValid(DateTime $date, $cartItems)
    {
        $localCartItems = $this->cloneCartItems($cartItems);

        return $this->isValidPromotion($date)
            and $this->areCartItemsValid($localCartItems);
    }

    /**
     * @param ArrayCollection<CartItem> | CartItem[] $cartItems
     * @return bool
     */
    public function areCartItemsValid(& $cartItems)
    {
        if (count($this->cartPriceRuleItems) === 0) {
            return false;
        }

        $matchedItems = $this->getCartItemMatches($cartItems);

        if (iterator_count($matchedItems) === count($this->cartPriceRuleItems)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param CartItem[] $cartItems
     * @return CartItem[]|\Generator
     */
    private function getCartItemMatches(& $cartItems)
    {
        foreach ($this->cartPriceRuleItems as $cartPriceRuleItem) {
            foreach ($cartItems as & $cartItem) {
                if ($cartPriceRuleItem->matches($cartItem)) {
                    $newQuantity = $cartItem->getQuantity() - $cartPriceRuleItem->getQuantity();
                    $cartItem->setQuantity($newQuantity);

                    yield $cartItem;
                    break;
                }
            }
        }
    }

    /**
     * @param CartItem[] $cartItems
     * @return int
     */
    public function numberTimesToApply($cartItems)
    {
        $numberTimesToApply = 0;
        $localCartItems = $this->cloneCartItems($cartItems);

        while ($this->areCartItemsValid($localCartItems)) {
            $numberTimesToApply++;
        }

        return $numberTimesToApply;
    }

    /**
     * @param CartItem[] $cartItems
     * @return CartItem[]
     */
    private function cloneCartItems($cartItems)
    {
        $localCartItems = [];

        foreach ($cartItems as $cartItem) {
            $localCartItems[] = clone $cartItem;
        }

        return $localCartItems;
    }
}
