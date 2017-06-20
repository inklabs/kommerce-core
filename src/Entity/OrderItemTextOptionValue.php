<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;

class OrderItemTextOptionValue implements IdEntityInterface
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
        $this->setId();
        $this->setCreated();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        // TODO: Implement loadValidatorMetadata() method.
    }

    public function getTextOption(): TextOption
    {
        return $this->textOption;
    }

    public function setTextOption(TextOption $textOption)
    {
        $this->textOption = $textOption;
        $this->textOptionName = $textOption->getName();
    }

    public function getTextOptionName(): string
    {
        return $this->textOptionName;
    }

    public function getTextOptionValue(): string
    {
        return $this->textOptionValue;
    }

    public function setTextOptionValue(string $textOptionValue)
    {
        $this->textOptionValue = $textOptionValue;
    }

    public function getOrderItem(): OrderItem
    {
        return $this->orderItem;
    }

    public function setOrderItem(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;
    }
}
