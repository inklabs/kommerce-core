<?php
namespace inklabs\kommerce\Entity;

abstract class CartPriceRuleItem
{
    use Accessor\Time;

    protected $id;
    protected $quantity;

    abstract public function matches(CartItem $cartItem);

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->setUpdated();
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
