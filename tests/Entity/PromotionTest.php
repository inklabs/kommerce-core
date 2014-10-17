<?php
namespace inklabs\kommerce\Entity;

class PromotionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->promotion = new Promotion;
        $this->promotion->setName('20% Off in 2014');
        $this->promotion->setDiscountType('percent');
        $this->promotion->setValue(20);
        $this->promotion->setRedemptions(null);
        $this->promotion->setMaxRedemptions(null);
        $this->promotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->promotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->promotion->getId());
        $this->assertEquals('20% Off in 2014', $this->promotion->getName());
        $this->assertEquals('percent', $this->promotion->getDiscountType());
        $this->assertEquals(20, $this->promotion->getValue());
        $this->assertEquals(null, $this->promotion->getRedemptions());
        $this->assertEquals(null, $this->promotion->getMaxRedemptions());
        $this->assertInstanceOf('DateTime', $this->promotion->getStart());
        $this->assertInstanceOf('DateTime', $this->promotion->getEnd());
    }

    public function testIsDateValid()
    {
        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($this->promotion->isDateValid(new \DateTime('2013-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($this->promotion->isDateValid(new \DateTime('2015-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsRedemptionCountValid()
    {
        $this->promotion->setMaxRedemptions(null);
        $this->assertTrue($this->promotion->isRedemptionCountValid());

        $this->promotion->setMaxRedemptions(10);
        $this->promotion->setRedemptions(0);
        $this->assertTrue($this->promotion->isRedemptionCountValid());

        $this->promotion->setMaxRedemptions(10);
        $this->promotion->setRedemptions(15);
        $this->assertFalse($this->promotion->isRedemptionCountValid());
    }

    public function testGetDiscountValuePercent()
    {
        $unit_price = 1000; // $10
        $this->assertEquals(800, $this->promotion->getUnitPrice($unit_price));
    }

    public function testGetDiscountValueFixed()
    {
        $this->promotion->setDiscountType('fixed');
        $this->promotion->setValue(1000);

        $unit_price = 10000; // $100
        $this->assertEquals(9000, $this->promotion->getUnitPrice($unit_price));
    }

    /**
     * @expectedException \Exception
     */
    public function testInvalidDiscountType()
    {
        $this->promotion->setDiscountType('invalid');
        $unit_price = $this->promotion->getUnitPrice(0);
    }
}
