<?php
namespace inklabs\kommerce\Entity\CartPriceRuleDiscount;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\Accessor;

abstract class Discount
{
    use Accessor\Time;

    protected $id;
    protected $quantity;

    /* @var Entity\CartPriceRule */
    protected $cartPriceRule;

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

    /**
     * @return Entity\CartPriceRule
     */
    public function getCartPriceRule()
    {
        return $this->cartPriceRule;
    }
}
