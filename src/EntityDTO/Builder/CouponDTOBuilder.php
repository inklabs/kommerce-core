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
    protected $entity;

    /** @var CouponDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new CouponDTO();
    }

    protected function preBuild()
    {
        $this->entityDTO->code             = $this->entity->getCode();
        $this->entityDTO->flagFreeShipping = $this->entity->getFlagFreeShipping();
        $this->entityDTO->minOrderValue    = $this->entity->getMinOrderValue();
        $this->entityDTO->maxOrderValue    = $this->entity->getMaxOrderValue();
        $this->entityDTO->canCombineWithOtherCoupons = $this->entity->getCanCombineWithOtherCoupons();
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
