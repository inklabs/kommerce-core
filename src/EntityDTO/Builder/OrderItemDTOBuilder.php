<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\EntityDTO\OrderItemDTO;
use inklabs\kommerce\Lib\BaseConvert;

class OrderItemDTOBuilder
{
    /** @var OrderItem */
    protected $orderItem;

    /** @var OrderItemDTO */
    protected $orderItemDTO;

    public function __construct(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;

        $this->orderItemDTO = new OrderItemDTO;
        $this->orderItemDTO->id             = $this->orderItem->getId();
        $this->orderItemDTO->encodedId      = BaseConvert::encode($this->orderItem->getId());
        $this->orderItemDTO->quantity       = $this->orderItem->getQuantity();
        $this->orderItemDTO->sku            = $this->orderItem->getSku();
        $this->orderItemDTO->name           = $this->orderItem->getName();
        $this->orderItemDTO->discountNames  = $this->orderItem->getDiscountNames();
        $this->orderItemDTO->created        = $this->orderItem->getCreated();
        $this->orderItemDTO->updated        = $this->orderItem->getUpdated();
        $this->orderItemDTO->areAttachmentsEnabled = $this->orderItem->areAttachmentsEnabled();

        if ($this->orderItem->getPrice() !== null) {
            $this->orderItemDTO->price = $orderItem->getPrice()->getDTOBuilder()
                ->withAllData()
                ->build();
        }

        if ($this->orderItem->getProduct() !== null) {
            $this->orderItemDTO->shippingWeight = $this->orderItem->getShippingWeight();
            $this->orderItemDTO->product = $this->orderItem->getProduct()->getDTOBuilder()
                ->withTags()
                ->build();
        }
    }

    public function withCatalogPromotions()
    {
        foreach ($this->orderItem->getCatalogPromotions() as $catalogPromotion) {
            $this->orderItemDTO->catalogPromotions[] = $catalogPromotion->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withProductQuantityDiscounts()
    {
        foreach ($this->orderItem->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $this->orderItemDTO->productQuantityDiscounts[] = $productQuantityDiscount->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withOrderItemOptionProducts()
    {
        foreach ($this->orderItem->getOrderItemOptionProducts() as $orderItemOptionProduct) {
            $this->orderItemDTO->orderItemOptionProducts[] = $orderItemOptionProduct->getDTOBuilder()
                ->withAllData()
                ->build();
        }

        return $this;
    }

    public function withOrderItemOptionValues()
    {
        foreach ($this->orderItem->getOrderItemOptionValues() as $orderItemOptionValue) {
            $this->orderItemDTO->orderItemOptionValues[] = $orderItemOptionValue->getDTOBuilder()
                ->withAllData()
                ->build();
        }

        return $this;
    }

    public function withOrderItemTextOptionValues()
    {
        foreach ($this->orderItem->getOrderItemTextOptionValues() as $orderItemTextOptionValue) {
            $this->orderItemDTO->orderItemTextOptionValues[] = $orderItemTextOptionValue->getDTOBuilder()
                ->withAllData()
                ->build();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withCatalogPromotions()
            ->withProductQuantityDiscounts()
            ->withOrderItemOptionProducts()
            ->withOrderItemOptionValues()
            ->withOrderItemTextOptionValues();
    }

    public function build()
    {
        return $this->orderItemDTO;
    }
}
