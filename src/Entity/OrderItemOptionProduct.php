<?php
namespace inklabs\kommerce\Entity;

class OrderItemOptionProduct implements EntityInterface
{
    use TimeTrait, IdTrait;

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
        $this->setId();
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
    }
}
