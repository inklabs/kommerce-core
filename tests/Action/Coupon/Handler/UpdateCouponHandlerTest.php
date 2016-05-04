<?php
namespace inklabs\kommerce\Action\Coupon\Handler;

use inklabs\kommerce\Action\Coupon\UpdateCouponCommand;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateCouponHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $couponService = $this->mockService->getCouponService();
        $couponService->shouldReceive('update')
            ->once();

        $command = new UpdateCouponCommand(new CouponDTO);
        $handler = new UpdateCouponHandler($couponService);
        $handler->handle($command);
    }
}
