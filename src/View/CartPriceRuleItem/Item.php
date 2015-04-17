<?php
namespace inklabs\kommerce\View\CartPriceRuleItem;

use inklabs\kommerce\Entity;

abstract class Item
{
    public $id;
    public $quantity;
    public $created;
    public $updated;

    public function __construct(Entity\CartPriceRuleItem\Item $item)
    {
        $this->item = $item;

        $this->id       = $item->getId();
        $this->quantity = $item->getQuantity();
        $this->created  = $item->getCreated();
        $this->updated  = $item->getUpdated();

        return $this;
    }

    public function export()
    {
        unset($this->item);
        return $this;
    }
}
