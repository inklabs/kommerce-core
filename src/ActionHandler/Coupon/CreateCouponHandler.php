<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\CreateCouponCommand;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Service\CouponServiceInterface;

final class CreateCouponHandler
{
    /** @var CouponServiceInterface */
    protected $couponService;

    public function __construct(CouponServiceInterface $couponService)
    {
        $this->couponService = $couponService;
    }

    public function handle(CreateCouponCommand $command)
    {
        $coupon = new Coupon(
            $command->getCode(),
            $command->getCouponId()
        );

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

        $this->couponService->create($coupon);
    }
}
