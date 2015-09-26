<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderItemOptionValueDTOBuilder;
use inklabs\kommerce\View;

class OrderItemOptionValue
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $sku;

    /** @var string */
    protected $optionName;

    /** @var string */
    protected $optionValueName;

    /** @var OptionValue */
    protected $optionValue;

    /** @var OrderItem */
    protected $orderItem;

    public function __construct()
    {
        $this->setCreated();
    }

    public function getOptionValue()
    {
        return $this->optionValue;
    }

    public function setOptionValue(OptionValue $optionValue)
    {
        $this->optionValue = $optionValue;
        $this->sku = $optionValue->getSku();
        $this->optionName = $optionValue->getOption()->getName();
        $this->optionValueName = $optionValue->getName();
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getOptionName()
    {
        return $this->optionName;
    }

    public function getOptionValueName()
    {
        return $this->optionValueName;
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
        return new View\OrderItemOptionValue($this);
    }

    public function getDTOBuilder()
    {
        return new OrderItemOptionValueDTOBuilder($this);
    }
}
