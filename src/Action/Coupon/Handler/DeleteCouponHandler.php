<?php
namespace inklabs\kommerce\Action\Coupon\Handler;

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
        $coupon = $this->couponService->findOneById($command->getId());
        $this->couponService->delete($coupon);
    }
}
