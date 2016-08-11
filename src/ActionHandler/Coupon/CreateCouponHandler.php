<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\CreateCouponCommand;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;
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
        $coupon->setType(PromotionType::createById($command->getPromotionTypeId()));
        $coupon->setValue($command->getValue());
        $coupon->setReducesTaxSubtotal($command->getReducesTaxSubtotal());
        $coupon->setMaxRedemptions($command->getMaxRedemptions());
        $coupon->setStart($command->getStartDate());
        $coupon->setEnd($command->getEndDate());

        $this->couponService->create($coupon);
    }
}
