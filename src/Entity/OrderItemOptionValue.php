<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderItemOptionValueDTOBuilder;
use Ramsey\Uuid\UuidInterface;

class OrderItemOptionValue
{
    use TimeTrait, IdTrait;

    use TempUuidTrait;
    private $orderItem_uuid;
    private $optionValue_uuid;

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
        $this->setUuid();
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

        $this->setOptionValueUuid($optionValue->getUuid());
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
        $this->setOrderItemUuid($orderItem->getUuid());
    }

    public function getDTOBuilder()
    {
        return new OrderItemOptionValueDTOBuilder($this);
    }

    // TODO: Remove after uuid_migration
    public function setOrderItemUuid(UuidInterface $uuid)
    {
        $this->orderItem_uuid = $uuid;
    }

    // TODO: Remove after uuid_migration
    public function setOptionValueUuid(UuidInterface $uuid)
    {
        $this->optionValue_uuid = $uuid;
    }
}
