<?php
use inklabs\kommerce\Entity\Coupon;

class CouponTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers Coupon::is_min_order_value_valid
	 */
	public function test_is_min_order_value_valid()
	{
		$coupon = new Coupon;
		$coupon->name = '20% Off orders over $100';
		$coupon->discount_type = 'percent';
		$coupon->discount_value = 20;
		$coupon->min_order_value = 10000; // $100

		$this->assertFalse($coupon->is_min_order_value_valid(5000));
		$this->assertTrue( $coupon->is_min_order_value_valid(50000));
	}

	/**
	 * @covers Coupon::is_max_order_value_valid
	 */
	public function test_is_max_order_value_valid()
	{
		$coupon = new Coupon;
		$coupon->name = '20% Off orders under $100';
		$coupon->discount_type = 'percent';
		$coupon->discount_value = 20;
		$coupon->max_order_value = 10000; // $100

		$this->assertTrue( $coupon->is_max_order_value_valid(5000));
		$this->assertFalse($coupon->is_max_order_value_valid(50000));
	}

	/**
	 * @covers Coupon::is_valid
	 */
	public function test_is_valid()
	{
		$coupon = new Coupon;
		$coupon->name = '20% Off orders $10-$100';
		$coupon->discount_type = 'percent';
		$coupon->discount_value = 20;
		$coupon->min_order_value = 1000; // $10
		$coupon->max_order_value = 10000; // $100
		$coupon->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
		$coupon->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

		$date = new \DateTime('2014-02-01', new DateTimeZone('UTC'));

		$this->assertTrue($coupon->is_valid($date, 5000));
	}
}
