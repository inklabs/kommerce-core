<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CouponDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $coupon = $this->dummyData->getCoupon();

        $couponDTO = $coupon->getDTOBuilder()
            ->build();

        $this->assertTrue($couponDTO instanceof CouponDTO);
    }
}
