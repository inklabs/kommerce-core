<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Entity\OptionValue\OptionValueInterface;
use inklabs\kommerce\View;

class OrderItemOptionValue
{
    use Accessor\Time, Accessor\Id;

    /** @var string */
    protected $sku;

    /** @var string */
    protected $optionTypeName;

    /** @var string */
    protected $optionValueName;

    /** @var OptionValueInterface */
    protected $optionValue;

    /** @var OrderItem */
    protected $orderItem;

    public function __construct(OptionValue\OptionValueInterface $optionValue)
    {
        $this->setCreated();
        $this->setOptionValue($optionValue);
    }

    public function getOptionValue()
    {
        return $this->optionValue;
    }

    public function setOptionValue(OptionValue\OptionValueInterface $optionValue)
    {
        $this->optionValue = $optionValue;
        $this->sku = $optionValue->getSku();
        $this->optionTypeName = $optionValue->getOptionType()->getName();
        $this->optionValueName = $optionValue->getName();
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getOptionTypeName()
    {
        return $this->optionTypeName;
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
}
