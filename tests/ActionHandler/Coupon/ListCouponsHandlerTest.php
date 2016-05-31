<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\ListCouponsQuery;
use inklabs\kommerce\Action\Coupon\Query\ListCouponsRequest;
use inklabs\kommerce\Action\Coupon\Query\ListCouponsResponse;
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

        $handler = new ListCouponsHandler($couponService, $this->getDTOBuilderFactory());
        $handler->handle(new ListCouponsQuery($request, $response));

        $this->assertTrue($response->getCouponDTOs()->current() instanceof CouponDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
