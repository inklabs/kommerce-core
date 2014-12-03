<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

abstract class Promotion
{
    public $id;
    public $name;
    public $type; // fixed, percent, exact
    public $value;
    public $redemptions;
    public $maxRedemptions;
    public $reducesTaxSubtotal;
    public $start;
    public $end;
    public $created;
    public $updated;

    public $isRedemptionCountValid;

    public function __construct(Entity\Promotion $promotion)
    {
        $this->promotion = $promotion;

        $this->name           = $promotion->getName();
        $this->type           = $promotion->getType();
        $this->value          = $promotion->getValue();
        $this->redemptions    = $promotion->getRedemptions();
        $this->maxRedemptions = $promotion->getMaxRedemptions();
        $this->start          = $promotion->getStart();
        $this->end            = $promotion->getEnd();
        $this->created        = $promotion->getCreated();
        $this->updated        = $promotion->getUpdated();

        $this->isRedemptionCountValid = $promotion->isRedemptionCountValid();

        return $this;
    }

    public function export()
    {
        unset($this->promotion);
        return $this;
    }
}
