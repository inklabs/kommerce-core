<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\EntityDTO\ProductQuantityDiscountDTO;
use inklabs\kommerce\Lib\Pricing;

/**
 * @method ProductQuantityDiscountDTO build()
 */
class ProductQuantityDiscountDTOBuilder extends AbstractPromotionDTOBuilder
{
    /** @var ProductQuantityDiscount */
    protected $promotion;

    /** @var ProductQuantityDiscountDTO */
    protected $promotionDTO;

    public function __construct(ProductQuantityDiscount $productQuantityDiscount)
    {
        $this->promotionDTO = new ProductQuantityDiscountDTO;

        parent::__construct($productQuantityDiscount);

        $this->promotionDTO->customerGroup              = $this->promotion->getCustomerGroup();
        $this->promotionDTO->quantity                   = $this->promotion->getQuantity();
        $this->promotionDTO->flagApplyCatalogPromotions = $this->promotion->getFlagApplyCatalogPromotions();
    }

    public function withPrice(Pricing $pricing)
    {
        $this->promotionDTO->price = $this->promotion->getPrice($pricing)->getDTOBuilder()
            ->withAllData()
            ->build();

        return $this;
    }

    public function withProduct(Pricing $pricing)
    {
        $product = $this->promotion->getProduct();
        if ($product !== null) {
            $this->promotionDTO->product = $product->getDTOBuilder()
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
