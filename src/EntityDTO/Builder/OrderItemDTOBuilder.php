<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\EntityDTO\OrderItemDTO;

class OrderItemDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var OrderItem */
    protected $entity;

    /** @var OrderItemDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(OrderItem $orderItem, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $orderItem;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = $this->getEntityDTO();
        $this->setId();
        $this->setTime();
        $this->entityDTO->quantity      = $this->entity->getQuantity();
        $this->entityDTO->sku           = $this->entity->getSku();
        $this->entityDTO->name          = $this->entity->getName();
        $this->entityDTO->discountNames = $this->entity->getDiscountNames();
        $this->entityDTO->areAttachmentsEnabled = $this->entity->areAttachmentsEnabled();

        if ($this->entity->getPrice() !== null) {
            $this->entityDTO->price = $this->dtoBuilderFactory
                ->getPriceDTOBuilder($orderItem->getPrice())
                ->withAllData()
                ->build();
        }

        if ($this->entity->getProduct() !== null) {
            $this->entityDTO->shippingWeight = $this->entity->getShippingWeight();
            $this->entityDTO->product = $this->dtoBuilderFactory
                ->getProductDTOBuilder($this->entity->getProduct())
                ->withTags()
                ->build();
        }
    }

    protected function getEntityDTO()
    {
        return new OrderItemDTO;
    }

    public function withCatalogPromotions()
    {
        foreach ($this->entity->getCatalogPromotions() as $catalogPromotion) {
            $this->entityDTO->catalogPromotions[] = $this->dtoBuilderFactory
                ->getCatalogPromotionDTOBuilder($catalogPromotion)
                ->build();
        }
        return $this;
    }

    public function withProductQuantityDiscounts()
    {
        foreach ($this->entity->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $this->entityDTO->productQuantityDiscounts[] = $this->dtoBuilderFactory
                ->getProductQuantityDiscountDTOBuilder($productQuantityDiscount)
                ->build();
        }
        return $this;
    }

    public function withOrderItemOptionProducts()
    {
        foreach ($this->entity->getOrderItemOptionProducts() as $orderItemOptionProduct) {
            $this->entityDTO->orderItemOptionProducts[] = $this->dtoBuilderFactory
                ->getOrderItemOptionProductDTOBuilder($orderItemOptionProduct)
                ->withAllData()
                ->build();
        }

        return $this;
    }

    public function withOrderItemOptionValues()
    {
        foreach ($this->entity->getOrderItemOptionValues() as $orderItemOptionValue) {
            $this->entityDTO->orderItemOptionValues[] = $this->dtoBuilderFactory
                ->getOrderItemOptionValueDTOBuilder($orderItemOptionValue)
                ->withAllData()
                ->build();
        }

        return $this;
    }

    public function withOrderItemTextOptionValues()
    {
        foreach ($this->entity->getOrderItemTextOptionValues() as $orderItemTextOptionValue) {
            $this->entityDTO->orderItemTextOptionValues[] = $this->dtoBuilderFactory
                ->getOrderItemTextOptionValueDTOBuilder($orderItemTextOptionValue)
                ->withAllData()
                ->build();
        }

        return $this;
    }

    public function withAttachments()
    {
        foreach ($this->entity->getAttachments() as $attachment) {
            $this->entityDTO->attachments[] = $this->dtoBuilderFactory
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
