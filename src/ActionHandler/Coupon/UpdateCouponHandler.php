<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\UpdateCouponCommand;

final class UpdateCouponHandler extends AbstractCouponHandler
{
    public function handle(UpdateCouponCommand $command)
    {
        $coupon = $this->couponRepository->findOneById(
            $command->getCouponId()
        );

        $this->updateCouponFromCommand($coupon, $command);

        $this->couponRepository->update($coupon);
    }
}
