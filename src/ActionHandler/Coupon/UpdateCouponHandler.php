<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\UpdateCouponCommand;
use inklabs\kommerce\EntityDTO\Builder\CouponDTOBuilder;
use inklabs\kommerce\Service\CouponServiceInterface;

final class UpdateCouponHandler
{
    /** @var CouponServiceInterface */
    protected $couponService;

    public function __construct(CouponServiceInterface $couponService)
    {
        $this->couponService = $couponService;
    }

    public function handle(UpdateCouponCommand $command)
    {
        $couponDTO = $command->getCouponDTO();
        $coupon = $this->couponService->findOneById($couponDTO->id);
        CouponDTOBuilder::setFromDTO($coupon, $couponDTO);

        $this->couponService->update($coupon);
    }
}
