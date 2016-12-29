<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\AbstractCouponCommand;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;

abstract class AbstractCouponHandler
{
    /** @var CouponRepositoryInterface */
    protected $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function updateCouponFromCommand(Coupon $coupon, AbstractCouponCommand $command)
    {
        $coupon->setCode($command->getCode());
        $coupon->setFlagFreeShipping($command->getFlagFreeShipping());
        $coupon->setMinOrderValue($command->getMinOrderValue());
        $coupon->setMaxOrderValue($command->getMaxOrderValue());
        $coupon->setCanCombineWithOtherCoupons($command->canCombineWithOtherCoupons());
        $coupon->setName($command->getName());
        $coupon->setType($command->getPromotionType());
        $coupon->setValue($command->getValue());
        $coupon->setReducesTaxSubtotal($command->getReducesTaxSubtotal());
        $coupon->setMaxRedemptions($command->getMaxRedemptions());
        $coupon->setStartAt($command->getStartAt());
        $coupon->setEndAt($command->getEndAt());
    }
}
