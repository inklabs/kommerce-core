<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\EntityDTO\CouponDTO;

/**
 * @method CouponDTO build()
 */
class CouponDTOBuilder extends PromotionDTOBuilder
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
}
