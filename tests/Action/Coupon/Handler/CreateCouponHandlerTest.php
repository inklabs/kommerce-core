<?php
namespace inklabs\kommerce\Action\Coupon\Handler;

use inklabs\kommerce\Action\Coupon\CreateCouponCommand;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateCouponHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $couponService = $this->mockService->getCouponService();
        $couponService->shouldReceive('create')
            ->once();

        $command = new CreateCouponCommand(new CouponDTO);
        $handler = new CreateCouponHandler($couponService);
        $handler->handle($command);
    }
}
