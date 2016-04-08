<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CouponDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $coupon = $this->dummyData->getCoupon();

        $couponDTO = $coupon->getDTOBuilder()
            ->build();

        $this->assertTrue($couponDTO instanceof CouponDTO);
    }
}
