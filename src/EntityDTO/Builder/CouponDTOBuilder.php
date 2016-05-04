<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\EntityDTO\CouponDTO;

/**
 * @method CouponDTO build()
 */
class CouponDTOBuilder extends AbstractPromotionDTOBuilder
{
    /** @var Coupon */
    protected $promotion;

    /** @var CouponDTO */
    protected $promotionDTO;

    public function __construct(Coupon $coupon)
    {
        $this->promotionDTO = new CouponDTO;

        parent::__construct($coupon);

        $this->promotionDTO->code             = $this->promotion->getCode();
        $this->promotionDTO->flagFreeShipping = $this->promotion->getFlagFreeShipping();
        $this->promotionDTO->minOrderValue    = $this->promotion->getMinOrderValue();
        $this->promotionDTO->maxOrderValue    = $this->promotion->getMaxOrderValue();
        $this->promotionDTO->canCombineWithOtherCoupons = $this->promotion->getCanCombineWithOtherCoupons();
    }

    public static function createFromDTO(CouponDTO $couponDTO)
    {
        $coupon = new Coupon($couponDTO->code);
        self::setFromDTO($coupon, $couponDTO);
        return $coupon;
    }

    public static function setFromDTO(Coupon & $coupon, CouponDTO $couponDTO)
    {
        $coupon->setCode($couponDTO->code);
        $coupon->setFlagFreeShipping($couponDTO->flagFreeShipping);
        $coupon->setMinOrderValue($couponDTO->minOrderValue);
        $coupon->setMaxOrderValue($couponDTO->maxOrderValue);
        $coupon->setCanCombineWithOtherCoupons($couponDTO->canCombineWithOtherCoupons);
    }
}
