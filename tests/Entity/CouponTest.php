<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Coupon;

class CouponTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->coupon = new Coupon;
        $this->coupon->setName('20% Off orders over $100');
        $this->coupon->setDiscountType('percent');
        $this->coupon->setValue(20);
        $this->coupon->setMinOrderValue(10000); // $100
    }

    public function testIsMinOrderValueValid()
    {
        $this->assertFalse($this->coupon->isMinOrderValueValid(5000));
        $this->assertTrue($this->coupon->isMinOrderValueValid(50000));
    }

    public function testIsMaxOrderValueValid()
    {
        $this->coupon->setName('20% Off orders under $100');
        $this->coupon->setDiscountType('percent');
        $this->coupon->setValue(20);
        $this->coupon->setMaxOrderValue(null);
        $this->coupon->setMaxOrderValue(10000); // $100

        $this->assertTrue($this->coupon->isMaxOrderValueValid(5000));
        $this->assertFalse($this->coupon->isMaxOrderValueValid(50000));
    }

    public function testIsValid()
    {
        $this->coupon = new Coupon;
        $this->coupon->setName('20% Off orders $10-$100');
        $this->coupon->setDiscountType('percent');
        $this->coupon->setValue(20);
        $this->coupon->setMinOrderValue(1000); // $10
        $this->coupon->setMaxOrderValue(10000); // $100
        $this->coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));

        $this->assertTrue($this->coupon->isValid($date, 5000));
    }
}
