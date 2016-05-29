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

interface DTOBuilderFactoryInterface
{
    /**
     * @param CatalogPromotion $catalogPromotion
     * @return CatalogPromotionDTOBuilder
     */
    public function getCatalogPromotionDTOBuilder(CatalogPromotion $catalogPromotion);

    /**
     * @param Coupon $coupon
     * @return CouponDTOBuilder
     */
    public function getCouponDTOBuilder(Coupon $coupon);

    /**
     * @param Image $image
     * @return ImageDTOBuilder
     */
    public function getImageDTOBuilder(Image $image);

    /**
     * @param Option $option
     * @return OptionDTOBuilder
     */
    public function getOptionDTOBuilder(Option $option);

    /**
     * @param OptionProduct $optionProduct
     * @return OptionProductDTOBuilder
     */
    public function getOptionProductDTOBuilder(OptionProduct $optionProduct);

    /**
     * @param Pagination $pagination
     * @return PaginationDTOBuilder
     */
    public function getPaginationDTOBuilder(Pagination $pagination);

    /**
     * @param Price $price
     * @return PriceDTOBuilder
     */
    public function getPriceDTOBuilder(Price $price);

    /**
     * @param PromotionType $promotionType
     * @return PromotionTypeDTOBuilder
     */
    public function getPromotionTypeDTOBuilder(PromotionType $promotionType);

    /**
     * @param Product $product
     * @return ProductDTOBuilder
     */
    public function getProductDTOBuilder(Product $product);

    /**
     * @param ProductAttribute $productAttribute
     * @return ProductAttributeDTOBuilder
     */
    public function getProductAttributeDTOBuilder(ProductAttribute $productAttribute);

    /**
     * @param ProductQuantityDiscount $productQuantityDiscount
     * @return ProductQuantityDiscountDTOBuilder
     */
    public function getProductQuantityDiscountDTOBuilder(ProductQuantityDiscount $productQuantityDiscount);

    /**
     * @param Tag $tag
     * @return TagDTOBuilder
     */
    public function getTagDTOBuilder(Tag $tag);

    /**
     * @param TextOption $textOption
     * @return TextOptionDTOBuilder
     */
    public function getTextOptionDTOBuilder(TextOption $textOption);
}
