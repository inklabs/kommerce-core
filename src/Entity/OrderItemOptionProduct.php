<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;

class OrderItemOptionProduct implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string|null */
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

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        // TODO: Implement loadValidatorMetadata() method.
    }

    public function getOptionProduct(): OptionProduct
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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function getOptionName(): string
    {
        return $this->optionName;
    }

    public function getOptionProductName(): string
    {
        return $this->optionProductName;
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
