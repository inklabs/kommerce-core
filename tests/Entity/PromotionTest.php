<?php
use inklabs\kommerce\Entity\Promotion;

class PromotionTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers Promotion::is_date_valid
	 */
	public function test_is_date_valid()
	{
		$promotion = new Promotion;
		$promotion->name = '20% Off';
		$promotion->discount_type = 'percent';
		$promotion->discount_value = 20;
		$promotion->start = new \DateTime('2014-01-01', new DateTimeZone('UTC'));
		$promotion->end   = new \DateTime('2014-12-31', new DateTimeZone('UTC'));

		$this->assertTrue( $promotion->is_date_valid(new \DateTime('2014-02-01', new DateTimeZone('UTC'))));
		$this->assertFalse($promotion->is_date_valid(new \DateTime('2013-02-01', new DateTimeZone('UTC'))));
		$this->assertFalse($promotion->is_date_valid(new \DateTime('2015-02-01', new DateTimeZone('UTC'))));
	}

	/**
	 * @covers Promotion::is_redemption_count_valid
	 */
	public function test_is_redemption_count_valid()
	{
		$promotion = new Promotion;
		$promotion->name = '20% Off';
		$promotion->discount_type = 'percent';
		$promotion->discount_value = 20;

		$promotion->max_redemptions = NULL;
		$this->assertTrue($promotion->is_redemption_count_valid());

		$promotion->max_redemptions = 10;
		$promotion->redemptions = 0;
		$this->assertTrue($promotion->is_redemption_count_valid());

		$promotion->max_redemptions = 10;
		$promotion->redemptions = 15;
		$this->assertFalse($promotion->is_redemption_count_valid());
	}

	/**
	 * @covers Promotion::get_discount_value
	 */
	public function test_get_discount_value_percent()
	{
		$promotion = new Promotion;
		$promotion->name = '20% Off';
		$promotion->discount_type = 'percent';
		$promotion->value = 20;

		$unit_price = 1000; // $10

		$this->assertEquals(800, $promotion->get_price($unit_price));
	}

	/**
	 * @covers Promotion::get_discount_value
	 */
	public function test_get_discount_value_fixed()
	{
		$promotion = new Promotion;
		$promotion->name = '$10 Off';
		$promotion->discount_type = 'fixed';
		$promotion->value = 1000;

		$unit_price = 10000; // $100

		$this->assertEquals(9000, $promotion->get_price($unit_price));
	}
}
