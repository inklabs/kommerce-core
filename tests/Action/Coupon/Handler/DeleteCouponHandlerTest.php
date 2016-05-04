<?php
namespace inklabs\kommerce\Action\Coupon\Handler;

use inklabs\kommerce\Action\Coupon\DeleteCouponCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteCouponHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $couponService = $this->mockService->getCouponService();
        $couponService->shouldReceive('delete')
            ->once();

        $command = new DeleteCouponCommand(1);
        $handler = new DeleteCouponHandler($couponService);
        $handler->handle($command);
    }
}
