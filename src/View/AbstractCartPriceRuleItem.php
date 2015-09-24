<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

abstract class AbstractCartPriceRuleItem implements View\ViewInterface
{
    public $id;
    public $quantity;
    public $created;
    public $updated;

    public function __construct(Entity\AbstractCartPriceRuleItem $item)
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
