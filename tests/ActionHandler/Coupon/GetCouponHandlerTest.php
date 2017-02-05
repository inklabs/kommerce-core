<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\GetCouponQuery;
use inklabs\kommerce\Action\Coupon\Query\GetCouponRequest;
use inklabs\kommerce\Action\Coupon\Query\GetCouponResponse;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCouponHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Coupon::class,
    ];

    public function testHandle()
    {
        $coupon = $this->dummyData->getCoupon();
        $this->persistEntityAndFlushClear($coupon);
        $request = new GetCouponRequest($coupon->getId()->getHex());
        $response = new GetCouponResponse();
        $query = new GetCouponQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertEquals($coupon->getId(), $response->getCouponDTO()->id);
    }
}
