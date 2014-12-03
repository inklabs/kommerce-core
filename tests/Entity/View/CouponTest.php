<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CouponTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCoupon = new Entity\Coupon;

        $coupon = Coupon::factory($entityCoupon)
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Coupon', $coupon);
    }
}
