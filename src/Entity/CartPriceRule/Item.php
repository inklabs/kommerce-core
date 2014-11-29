<?php
namespace inklabs\kommerce\Entity\CartPriceRule;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\Accessor;

abstract class Item
{
    use Accessor\Time;

    protected $id;
    protected $quantity;

    abstract public function matches(Entity\CartItem $cartItem);

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
