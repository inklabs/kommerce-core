<?php
namespace inklabs\kommerce\Action\Coupon\Handler;

use inklabs\kommerce\Action\Coupon\ListCouponsRequest;
use inklabs\kommerce\Action\Coupon\Response\ListCouponsResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListCouponsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $couponService = $this->mockService->getCouponService();

        $queryString = 'PCT';
        $request = new ListCouponsRequest($queryString, new PaginationDTO);
        $response = new ListCouponsResponse;

        $handler = new ListCouponsHandler($couponService);
        $handler->handle($request, $response);

        $this->assertTrue($response->getCouponDTOs()[0] instanceof CouponDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
