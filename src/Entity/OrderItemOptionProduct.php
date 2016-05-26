<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderItemOptionProductDTOBuilder;
use Ramsey\Uuid\UuidInterface;

class OrderItemOptionProduct
{
    use TimeTrait, IdTrait;

    use TempUuidTrait;
    private $orderItem_uuid;
    private $optionProduct_uuid;

    /** @var string */
    protected $sku;

    /** @var string */
    protected $optionName;

    /** @var string */
    protected $optionProductName;

    /** @var OptionProduct */
    protected $optionProduct;

    /** @var OrderItem */
    protected $orderItem;

    public function __construct()
    {
        $this->setUuid();
        $this->setCreated();
    }

    public function getOptionProduct()
    {
        return $this->optionProduct;
    }

    public function setOptionProduct(OptionProduct $optionProduct)
    {
        $this->optionProduct = $optionProduct;
        $this->sku = $optionProduct->getSku();
        $this->optionName = $optionProduct->getOption()->getName();
        $this->optionProductName = $optionProduct->getName();

        $this->setOptionProductUuid($optionProduct->getUuid());
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getOptionName()
    {
        return $this->optionName;
    }

    public function getOptionProductName()
    {
        return $this->optionProductName;
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
        return new OrderItemOptionProductDTOBuilder($this);
    }

    // TODO: Remove after uuid_migration
    public function setOrderItemUuid(UuidInterface $uuid)
    {
        $this->orderItem_uuid = $uuid;
    }

    // TODO: Remove after uuid_migration
    public function setOptionProductUuid(UuidInterface $uuid)
    {
        $this->optionProduct_uuid = $uuid;
    }
}
