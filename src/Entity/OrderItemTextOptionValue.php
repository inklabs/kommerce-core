<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;

class OrderItemTextOptionValue
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $textOptionName;

    /** @var string */
    protected $textOptionValue;

    /** @var TextOption */
    protected $textOption;

    /** @var OrderItem */
    protected $orderItem;

    public function __construct()
    {
        $this->setCreated();
    }

    public function getTextOption()
    {
        return $this->textOption;
    }

    public function setTextOption(TextOption $textOption)
    {
        $this->textOption = $textOption;
        $this->textOptionName = $textOption->getName();
    }

    public function getTextOptionName()
    {
        return $this->textOptionName;
    }

    public function getTextOptionValue()
    {
        return $this->textOptionValue;
    }

    /**
     * @param string $textOptionValue
     */
    public function setTextOptionValue($textOptionValue)
    {
        $this->textOptionValue = $textOptionValue;
    }

    public function getOrderItem()
    {
        return $this->orderItem;
    }

    public function setOrderItem(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;
    }

    public function getView()
    {
        return new View\OrderItemTextOptionValue($this);
    }
}
