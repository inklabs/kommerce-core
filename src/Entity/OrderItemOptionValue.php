<?php
namespace inklabs\kommerce\Entity;

class OrderItemOptionValue
{
    use Accessor\Time, Accessor\Id;

    /** @var string */
    protected $sku;

    /** @var string */
    protected $name;

    /** @var string */
    protected $value;

    /** @var OrderItem */
    protected $orderItem;

    /** @var Option */
    protected $option;

    /** @var OptionValue */
    protected $optionValue;

    public function __construct(Option $option)
    {
        $this->setCreated();

        $this->setOption($option);
    }

    public function getOption()
    {
        return $this->option;
    }

    private function setOption(Option $option)
    {
        $this->option = $option;
        $this->name = $option->getName();
    }

    public function getOptionValue()
    {
        return $this->optionValue;
    }

    public function setOptionValue(OptionValue $optionValue)
    {
        $this->setOption($optionValue->getOption());
        $this->setSku($optionValue->getSku());
        $this->setValue($optionValue->getName());

        $this->optionValue = $optionValue;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->throwExceptionIfExistingOptionValue();

        $this->sku = (string) $sku;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->throwExceptionIfExistingOptionValue();

        $this->value = (string) $value;
    }

    /**
     * @throws \LogicException
    */
    private function throwExceptionIfExistingOptionValue()
    {
        if ($this->optionValue !== null) {
            throw new \LogicException('OptionValue already exists');
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getValue()
    {
        return $this->value;
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
