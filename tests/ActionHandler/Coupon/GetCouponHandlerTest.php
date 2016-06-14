<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\GetCouponQuery;
use inklabs\kommerce\Action\Coupon\Query\GetCouponRequest;
use inklabs\kommerce\Action\Coupon\Query\GetCouponResponse;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCouponHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $coupon = $this->dummyData->getCoupon();
        $couponService = $this->mockService->getCouponService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetCouponRequest($coupon->getId());
        $response = new GetCouponResponse;

        $handler = new GetCouponHandler($couponService, $dtoBuilderFactory);
        $handler->handle(new GetCouponQuery($request, $response));

        $this->assertTrue($response->getCouponDTO() instanceof CouponDTO);
    }
}
