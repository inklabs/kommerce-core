<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Price;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;

class DTOBuilderFactory implements DTOBuilderFactoryInterface
{
    public function getCatalogPromotionDTOBuilder(CatalogPromotion $catalogPromotion)
    {
        return new CatalogPromotionDTOBuilder($catalogPromotion, $this);
    }

    public function getCouponDTOBuilder(Coupon $coupon)
    {
        return new CouponDTOBuilder($coupon, $this);
    }

    public function getImageDTOBuilder(Image $image)
    {
        return new ImageDTOBuilder($image, $this);
    }

    public function getOptionDTOBuilder(Option $option)
    {
        return new OptionDTOBuilder($option, $this);
    }

    public function getOptionProductDTOBuilder(OptionProduct $optionProduct)
    {
        return new OptionProductDTOBuilder($optionProduct, $this);
    }

    public function getPaginationDTOBuilder(Pagination $pagination)
    {
        return new PaginationDTOBuilder($pagination, $this);
    }

    public function getPriceDTOBuilder(Price $price)
    {
        return new PriceDTOBuilder($price, $this);
    }

    public function getPromotionTypeDTOBuilder(PromotionType $promotionType)
    {
        return new PromotionTypeDTOBuilder($promotionType, $this);
    }

    public function getProductDTOBuilder(Product $product)
    {
        return new ProductDTOBuilder($product, $this);
    }

    public function getProductAttributeDTOBuilder(ProductAttribute $productAttribute)
    {
        return new ProductAttributeDTOBuilder($productAttribute, $this);
    }

    public function getProductQuantityDiscountDTOBuilder(ProductQuantityDiscount $productQuantityDiscount)
    {
        return new ProductQuantityDiscountDTOBuilder($productQuantityDiscount, $this);
    }

    public function getTagDTOBuilder(Tag $tag)
    {
        return new TagDTOBuilder($tag, $this);
    }

    public function getTextOptionDTOBuilder(TextOption $textOption)
    {
        return new TextOptionDTOBuilder($textOption, $this);
    }
}
