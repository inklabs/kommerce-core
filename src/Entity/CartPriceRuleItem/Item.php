<?php
namespace inklabs\kommerce\Entity\CartPriceRuleItem;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\Accessor;

abstract class Item
{
    use Accessor\Time;

    protected $id;
    protected $quantity;

    /* @var Entity\CartPriceRule */
    protected $cartPriceRule;

    abstract public function matches(Entity\CartItem $cartItem);

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setCartPriceRule(Entity\CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRule = $cartPriceRule;
    }

    public function getCartPriceRule()
    {
        return $this->cartPriceRule;
    }
}
