<?php
namespace inklabs\kommerce\Entity;

class OrderItemOptionValue
{
    use Accessor\Created, Accessor\Id;

    /** @var string */
    protected $optionName;

    /** @var string */
    protected $sku;

    /** @var string */
    protected $name;

    /** @var OrderItem */
    protected $orderItem;

    /** @var OptionValue */
    protected $optionValue;

    public function __construct(OptionValue $optionValue)
    {
        $this->setCreated();

        $this->setOptionValue($optionValue);
    }

    public function getOptionValue()
    {
        return $this->optionValue;
    }

    public function setOptionValue(OptionValue $optionValue)
    {
        $this->optionValue = $optionValue;
        $this->optionName = $optionValue->getOption()->getName();
        $this->sku = $optionValue->getSku();
        $this->name = $optionValue->getName();
    }

    public function getOptionName()
    {
        return $this->optionName;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
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
