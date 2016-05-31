<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\EntityDTO\OrderItemDTO;

class OrderItemDTOBuilder
{
    /** @var OrderItem */
    protected $orderItem;

    /** @var OrderItemDTO */
    protected $orderItemDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(OrderItem $orderItem, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->orderItem = $orderItem;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->orderItemDTO = new OrderItemDTO;
        $this->orderItemDTO->id            = $this->orderItem->getId();
        $this->orderItemDTO->quantity      = $this->orderItem->getQuantity();
        $this->orderItemDTO->sku           = $this->orderItem->getSku();
        $this->orderItemDTO->name          = $this->orderItem->getName();
        $this->orderItemDTO->discountNames = $this->orderItem->getDiscountNames();
        $this->orderItemDTO->created       = $this->orderItem->getCreated();
        $this->orderItemDTO->updated       = $this->orderItem->getUpdated();
        $this->orderItemDTO->areAttachmentsEnabled = $this->orderItem->areAttachmentsEnabled();

        if ($this->orderItem->getPrice() !== null) {
            $this->orderItemDTO->price = $this->dtoBuilderFactory
                ->getPriceDTOBuilder($orderItem->getPrice())
                ->withAllData()
                ->build();
        }

        if ($this->orderItem->getProduct() !== null) {
            $this->orderItemDTO->shippingWeight = $this->orderItem->getShippingWeight();
            $this->orderItemDTO->product = $this->dtoBuilderFactory
                ->getProductDTOBuilder($this->orderItem->getProduct())
                ->withTags()
                ->build();
        }
    }

    public function withCatalogPromotions()
    {
        foreach ($this->orderItem->getCatalogPromotions() as $catalogPromotion) {
            $this->orderItemDTO->catalogPromotions[] = $this->dtoBuilderFactory
                ->getCatalogPromotionDTOBuilder($catalogPromotion)
                ->build();
        }
        return $this;
    }

    public function withProductQuantityDiscounts()
    {
        foreach ($this->orderItem->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $this->orderItemDTO->productQuantityDiscounts[] = $this->dtoBuilderFactory
                ->getProductQuantityDiscountDTOBuilder($productQuantityDiscount)
                ->build();
        }
        return $this;
    }

    public function withOrderItemOptionProducts()
    {
        foreach ($this->orderItem->getOrderItemOptionProducts() as $orderItemOptionProduct) {
            $this->orderItemDTO->orderItemOptionProducts[] = $this->dtoBuilderFactory
                ->getOrderItemOptionProductDTOBuilder($orderItemOptionProduct)
                ->withAllData()
                ->build();
        }

        return $this;
    }

    public function withOrderItemOptionValues()
    {
        foreach ($this->orderItem->getOrderItemOptionValues() as $orderItemOptionValue) {
            $this->orderItemDTO->orderItemOptionValues[] = $this->dtoBuilderFactory
                ->getOrderItemOptionValueDTOBuilder($orderItemOptionValue)
                ->withAllData()
                ->build();
        }

        return $this;
    }

    public function withOrderItemTextOptionValues()
    {
        foreach ($this->orderItem->getOrderItemTextOptionValues() as $orderItemTextOptionValue) {
            $this->orderItemDTO->orderItemTextOptionValues[] = $this->dtoBuilderFactory
                ->getOrderItemTextOptionValueDTOBuilder($orderItemTextOptionValue)
                ->withAllData()
                ->build();
        }

        return $this;
    }

    public function withAttachments()
    {
        foreach ($this->orderItem->getAttachments() as $attachment) {
            $this->orderItemDTO->attachments[] = $this->dtoBuilderFactory
                ->getAttachmentDTOBuilder($attachment)
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
            ->withOrderItemTextOptionValues()
            ->withAttachments();
    }

    public function build()
    {
        return $this->orderItemDTO;
    }
}
