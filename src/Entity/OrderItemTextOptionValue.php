<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderItemTextOptionValueDTOBuilder;
use Ramsey\Uuid\UuidInterface;

class OrderItemTextOptionValue
{
    use TimeTrait, IdTrait;

    use TempUuidTrait;
    private $orderItem_uuid;
    private $textOption_uuid;

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
        $this->setUuid();
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
        $this->setTextOptionUuid($textOption->getUuid());
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
        $this->setOrderItemUuid($orderItem->getUuid());
    }

    public function getDTOBuilder()
    {
        return new OrderItemTextOptionValueDTOBuilder($this);
    }

    // TODO: Remove after uuid_migration
    public function setOrderItemUuid(UuidInterface $uuid)
    {
        $this->orderItem_uuid = $uuid;
    }

    // TODO: Remove after uuid_migration
    public function setTextOptionUuid(UuidInterface $uuid)
    {
        $this->textOption_uuid = $uuid;
    }
}
