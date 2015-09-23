<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Coupon;

class CouponDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $coupon = new Coupon;

        $couponDTO = $coupon->getDTOBuilder()
            ->build();

        $this->assertTrue($couponDTO instanceof CouponDTO);
    }
}
