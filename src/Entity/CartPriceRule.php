<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleDTOBuilder;
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

    public function getCartPriceRuleItems()
    {
        return $this->cartPriceRuleItems;
    }

    public function addDiscount(CartPriceRuleDiscount $discount)
    {
        $discount->setCartPriceRule($this);
        $this->cartPriceRuleDiscounts[] = $discount;
    }

    public function getCartPriceRuleDiscounts()
    {
        return $this->cartPriceRuleDiscounts;
    }

    public function isValid(DateTime $date, $cartItems)
    {
        return $this->isValidPromotion($date)
            and $this->isCartItemsValid($cartItems);
    }

    public function isCartItemsValid($cartItems)
    {
        $matchedItemsCount = 0;
        foreach ($this->cartPriceRuleItems as $item) {
            foreach ($cartItems as $cartItem) {
                if ($item->matches($cartItem)) {
                    $matchedItemsCount++;
                    break;
                }
            }
        }

        if ($matchedItemsCount == count($this->cartPriceRuleItems)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return CartPriceRuleDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new CartPriceRuleDTOBuilder($this);
    }
}
