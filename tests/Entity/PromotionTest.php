<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Promotion;

class PromotionTest extends \PHPUnit_Framework_TestCase
{
    public function testIsDateValid()
    {
        $promotion = new Promotion;
        $promotion->name = '20% Off';
        $promotion->discount_type = 'percent';
        $promotion->discount_value = 20;
        $promotion->start = new \DateTime('2014-01-01', new \DateTimeZone('UTC'));
        $promotion->end   = new \DateTime('2014-12-31', new \DateTimeZone('UTC'));

        $this->assertTrue($promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($promotion->isDateValid(new \DateTime('2013-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($promotion->isDateValid(new \DateTime('2015-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsRedemptionCountValid()
    {
        $promotion = new Promotion;
        $promotion->name = '20% Off';
        $promotion->discount_type = 'percent';
        $promotion->discount_value = 20;

        $promotion->max_redemptions = null;
        $this->assertTrue($promotion->isRedemptionCountValid());

        $promotion->max_redemptions = 10;
        $promotion->redemptions = 0;
        $this->assertTrue($promotion->isRedemptionCountValid());

        $promotion->max_redemptions = 10;
        $promotion->redemptions = 15;
        $this->assertFalse($promotion->isRedemptionCountValid());
    }

    public function testGetDiscountValuePercent()
    {
        $promotion = new Promotion;
        $promotion->name = '20% Off';
        $promotion->discount_type = 'percent';
        $promotion->value = 20;

        $unit_price = 1000; // $10

        $this->assertEquals(800, $promotion->getUnitPrice($unit_price));
    }

    public function testGetDiscountValueFixed()
    {
        $promotion = new Promotion;
        $promotion->name = '$10 Off';
        $promotion->discount_type = 'fixed';
        $promotion->value = 1000;

        $unit_price = 10000; // $100

        $this->assertEquals(9000, $promotion->getUnitPrice($unit_price));
    }

    /**
     * @expectedException \Exception
     */
    public function testInvalidDiscountType()
    {
        $promotion = new Promotion;
        $promotion->discount_type = 'invalid';

        $unit_price = $promotion->getUnitPrice(0);
    }
}
