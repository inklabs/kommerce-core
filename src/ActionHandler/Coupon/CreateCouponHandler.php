<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\CreateCouponCommand;
use inklabs\kommerce\Entity\Coupon;

final class CreateCouponHandler extends AbstractCouponHandler
{
    public function handle(CreateCouponCommand $command)
    {
        $coupon = new Coupon(
            $command->getCode(),
            $command->getCouponId()
        );

        $this->updateCouponFromCommand($coupon, $command);

        $this->couponRepository->create($coupon);
    }
}
