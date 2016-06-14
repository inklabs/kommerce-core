<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\DeleteCouponCommand;
use inklabs\kommerce\Service\CouponServiceInterface;

final class DeleteCouponHandler
{
    /** @var CouponServiceInterface */
    protected $couponService;

    public function __construct(CouponServiceInterface $couponService)
    {
        $this->couponService = $couponService;
    }

    public function handle(DeleteCouponCommand $command)
    {
        $coupon = $this->couponService->findOneById($command->getCouponId());
        $this->couponService->delete($coupon);
    }
}
