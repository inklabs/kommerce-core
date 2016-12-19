<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\PromotionType;
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
        $coupon->setName($couponDTO->name);
        $coupon->setCode($couponDTO->code);
        $coupon->setType(PromotionType::createById($couponDTO->type->id));
        $coupon->setValue($couponDTO->value);
        $coupon->setMinOrderValue($couponDTO->minOrderValue);
        $coupon->setMaxOrderValue($couponDTO->maxOrderValue);
        $coupon->setMaxRedemptions($couponDTO->maxRedemptions);
        $coupon->setFlagFreeShipping($couponDTO->flagFreeShipping);
        $coupon->setReducesTaxSubtotal($couponDTO->reducesTaxSubtotal);
        $coupon->setCanCombineWithOtherCoupons($couponDTO->canCombineWithOtherCoupons);
    }
}
