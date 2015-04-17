<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class CouponTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCoupon = new Entity\Coupon;

        $coupon = $entityCoupon->getView()
            ->export();

        $this->assertTrue($coupon instanceof Coupon);
    }
}
