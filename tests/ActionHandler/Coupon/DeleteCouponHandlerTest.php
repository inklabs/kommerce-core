<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\DeleteCouponCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteCouponHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $coupon = $this->dummyData->getCoupon();
        $couponService = $this->mockService->getCouponService();
        $couponService->shouldReceive('delete')
            ->once();

        $command = new DeleteCouponCommand($coupon->getId()->getHex());
        $handler = new DeleteCouponHandler($couponService);
        $handler->handle($command);
    }
}
