<?php
namespace inklabs\kommerce\Action\Coupon\Handler;

use inklabs\kommerce\Action\Coupon\GetCouponRequest;
use inklabs\kommerce\Action\Coupon\Response\GetCouponResponse;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCouponHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $couponService = $this->mockService->getCouponService();

        $request = new GetCouponRequest(1);
        $response = new GetCouponResponse;

        $handler = new GetCouponHandler($couponService);
        $handler->handle($request, $response);

        $this->assertTrue($response->getCouponDTO() instanceof CouponDTO);
    }
}
