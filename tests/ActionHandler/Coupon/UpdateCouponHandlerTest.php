<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

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

        $couponDTO = $this->getDTOBuilderFactory()
            ->getCouponDTOBuilder($this->dummyData->getCoupon())
            ->build();

        $command = new UpdateCouponCommand($couponDTO);
        $handler = new UpdateCouponHandler($couponService);
        $handler->handle($command);
    }
}
