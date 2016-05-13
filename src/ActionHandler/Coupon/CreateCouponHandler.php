<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\CreateCouponCommand;
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
        $coupon = CouponDTOBuilder::createFromDTO($command->getCouponDTO());
        $this->couponService->create($coupon);
    }
}
