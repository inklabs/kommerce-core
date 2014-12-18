<?php
namespace inklabs\kommerce\Entity\View\CartPriceRuleItem;

use inklabs\kommerce\Entity as Entity;

abstract class Item
{
    public $id;
    public $quantity;

    public function __construct(Entity\CartPriceRuleItem\Item $item)
    {
        $this->item = $item;

        $this->id       = $item->getId();
        $this->quantity = $item->getQuantity();

        return $this;
    }

    public function export()
    {
        unset($this->item);
        return $this;
    }
}
