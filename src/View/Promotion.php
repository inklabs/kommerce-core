<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

abstract class Promotion implements ViewInterface
{
    public $id;
    public $name;
    public $type;
    public $typeText;
    public $value;
    public $redemptions;
    public $maxRedemptions;
    public $reducesTaxSubtotal;
    public $start;
    public $end;
    public $startFormatted;
    public $endFormatted;
    public $created;
    public $updated;

    public $isRedemptionCountValid;

    public function __construct(Entity\Promotion $promotion)
    {
        $this->promotion = $promotion;

        $this->id             = $promotion->getId();
        $this->encodedId      = Lib\BaseConvert::encode($promotion->getId());
        $this->name           = $promotion->getName();
        $this->type           = $promotion->getType();
        $this->typeText       = $promotion->getTypeText();
        $this->value          = $promotion->getValue();
        $this->redemptions    = $promotion->getRedemptions();
        $this->maxRedemptions = $promotion->getMaxRedemptions();
        $this->start          = $promotion->getStart();
        $this->end            = $promotion->getEnd();
        $this->created        = $promotion->getCreated();
        $this->updated        = $promotion->getUpdated();

        if ($this->start !== null) {
            $this->startFormatted = $this->start->format('Y-m-d');
        }

        if ($this->end !== null) {
            $this->endFormatted = $this->end->format('Y-m-d');
        }

        $this->isRedemptionCountValid = $promotion->isRedemptionCountValid();
    }

    public function export()
    {
        unset($this->promotion);
        return $this;
    }
}
