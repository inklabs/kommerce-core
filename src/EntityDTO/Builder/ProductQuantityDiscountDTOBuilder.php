<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\EntityDTO\ProductQuantityDiscountDTO;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\PricingInterface;

/**
 * @method ProductQuantityDiscountDTO build()
 */
class ProductQuantityDiscountDTOBuilder extends AbstractPromotionDTOBuilder
{
    /** @var ProductQuantityDiscount */
    protected $entity;

    /** @var ProductQuantityDiscountDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new ProductQuantityDiscountDTO;
    }

    protected function preBuild()
    {
        $this->entityDTO->customerGroup  = $this->entity->getCustomerGroup();
        $this->entityDTO->quantity = $this->entity->getQuantity();
        $this->entityDTO->flagApplyCatalogPromotions = $this->entity->getFlagApplyCatalogPromotions();
    }

    /**
     * @return static
     */
    public function withPrice(PricingInterface $pricing)
    {
        $this->entityDTO->price = $this->dtoBuilderFactory
            ->getPriceDTOBuilder($this->entity->getPrice($pricing))
                ->withAllData()
                ->build();

        return $this;
    }

    /**
     * @return static
     */
    public function withProduct(Pricing $pricing)
    {
        $product = $this->entity->getProduct();
        if ($product !== null) {
            $this->entityDTO->product = $this->dtoBuilderFactory
                ->getProductDTOBuilder($product)
                ->withAllData($pricing)
                ->build();
        }
        return $this;
    }

    /**
     * @return static
     */
    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withPrice($pricing)
            ->withProduct($pricing);
    }
}
