<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\GetCouponQuery;
use inklabs\kommerce\ActionResponse\Coupon\GetCouponResponse;
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
        $query = new GetCouponQuery($coupon->getId()->getHex());

        /** @var GetCouponResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEquals($coupon->getId(), $response->getCouponDTO()->id);
    }
}
