<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;

class OrderItemOptionValue implements IdEntityInterface
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
        $this->setId();
        $this->setCreated();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        // TODO: Implement loadValidatorMetadata() method.
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
}
