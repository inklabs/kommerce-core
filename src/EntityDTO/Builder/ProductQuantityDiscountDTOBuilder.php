<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\EntityDTO\AbstractPromotionDTO;
use inklabs\kommerce\EntityDTO\ProductQuantityDiscountDTO;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\PricingInterface;

/**
 * @method ProductQuantityDiscountDTO build()
 */
class ProductQuantityDiscountDTOBuilder extends AbstractPromotionDTOBuilder
{
    /** @var ProductQuantityDiscount */
    protected $promotion;

    /** @var ProductQuantityDiscountDTO */
    protected $promotionDTO;

    protected function getPromotionDTO()
    {
        return new ProductQuantityDiscountDTO;
    }

    protected function preBuild()
    {
        $this->promotionDTO->customerGroup  = $this->promotion->getCustomerGroup();
        $this->promotionDTO->quantity = $this->promotion->getQuantity();
        $this->promotionDTO->flagApplyCatalogPromotions = $this->promotion->getFlagApplyCatalogPromotions();
    }

    public function withPrice(PricingInterface $pricing)
    {
        $this->promotionDTO->price = $this->dtoBuilderFactory
            ->getPriceDTOBuilder($this->promotion->getPrice($pricing))
                ->withAllData()
                ->build();

        return $this;
    }

    public function withProduct(Pricing $pricing)
    {
        $product = $this->promotion->getProduct();
        if ($product !== null) {
            $this->promotionDTO->product = $this->dtoBuilderFactory
                ->getProductDTOBuilder($product)
                ->withAllData($pricing)
                ->build();
        }
        return $this;
    }

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withPrice($pricing)
            ->withProduct($pricing);
    }
}
