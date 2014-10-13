<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Coupon;

class CouponTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Coupon::isMinOrderValueValid
     */
    public function testIsMinOrderValueValid()
    {
        $coupon = new Coupon;
        $coupon->name = '20% Off orders over $100';
        $coupon->discount_type = 'percent';
        $coupon->value = 20;
        $coupon->min_order_value = 10000; // $100

        $this->assertFalse($coupon->isMinOrderValueValid(5000));
        $this->assertTrue($coupon->isMinOrderValueValid(50000));
    }

    /**
     * @covers Coupon::isMaxOrderValueValid
     */
    public function testIsMaxOrderValueValid()
    {
        $coupon = new Coupon;
        $coupon->name = '20% Off orders under $100';
        $coupon->discount_type = 'percent';
        $coupon->value = 20;
        $coupon->max_order_value = 10000; // $100

        $this->assertTrue($coupon->isMaxOrderValueValid(5000));
        $this->assertFalse($coupon->isMaxOrderValueValid(50000));
    }

    /**
     * @covers Coupon::isValid
     */
    public function testIsValid()
    {
        $coupon = new Coupon;
        $coupon->name = '20% Off orders $10-$100';
        $coupon->discount_type = 'percent';
        $coupon->value = 20;
        $coupon->min_order_value = 1000; // $10
        $coupon->max_order_value = 10000; // $100
        $coupon->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $coupon->end   = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $date = new \DateTime('2014-02-01', new \DateTimeZone('UTC'));

        $this->assertTrue($coupon->isValid($date, 5000));
    }
}
