<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class OrderItemTextOptionValue implements ViewInterface
{
    /** @var int */
    public $id;

    /** @var int */
    public $created;

    /** @var int */
    public $updated;

    /** @var string */
    public $textOptionName;

    /** @var string */
    public $textOptionValue;

    /** @var TextOption */
    public $textOption;

    public function __construct(Entity\OrderItemTextOptionValue $orderItemTextOptionValue)
    {
        $this->orderItemTextOptionValue = $orderItemTextOptionValue;

        $this->id              = $orderItemTextOptionValue->getId();
        $this->created         = $orderItemTextOptionValue->getCreated();
        $this->updated         = $orderItemTextOptionValue->getUpdated();
        $this->textOptionName  = $orderItemTextOptionValue->getTextOptionName();
        $this->textOptionValue = $orderItemTextOptionValue->getTextOptionValue();
    }

    public function export()
    {
        unset($this->orderItemTextOptionValue);
        return $this;
    }

    public function withTextOption()
    {
        $this->textOption = $this->orderItemTextOptionValue->getTextOption()->getView()
            ->export();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTextOption();
    }
}
