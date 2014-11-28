<?php
namespace inklabs\kommerce\Entity;

class PromotionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->promotion = new Promotion;
        $this->promotion->setName('20% Off in 2014');
        $this->promotion->setType('percent');
        $this->promotion->setValue(20);
        $this->promotion->setRedemptions(null);
        $this->promotion->setMaxRedemptions(null);
        $this->promotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->promotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $reflection = new \ReflectionClass('inklabs\kommerce\Entity\View\Promotion');
        $this->expected = $reflection->newInstanceWithoutConstructor();
    }

    public function testIsDateValid()
    {
        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($this->promotion->isDateValid(new \DateTime('2013-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($this->promotion->isDateValid(new \DateTime('2015-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsDateValidNullStartEnd()
    {
        $this->promotion->setStart(null);
        $this->promotion->setEnd(null);

        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsDateValidNullStart()
    {
        $this->promotion->setStart(null);

        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2013-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($this->promotion->isDateValid(new \DateTime('2015-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsDateValidNullEnd()
    {
        $this->promotion->setEnd(null);

        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($this->promotion->isDateValid(new \DateTime('2013-02-01', new \DateTimeZone('UTC'))));
        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2015-02-01', new \DateTimeZone('UTC'))));
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
        $unitPrice = 1000;
        $this->assertEquals(800, $this->promotion->getUnitPrice($unitPrice));
    }

    public function testGetDiscountValueFixed()
    {
        $this->promotion->setType('fixed');
        $this->promotion->setValue(1000);

        $unitPrice = 10000;
        $this->assertEquals(9000, $this->promotion->getUnitPrice($unitPrice));
    }

    /**
     * @expectedException \Exception
     */
    public function testInvalidType()
    {
        $this->promotion->setType('invalid');
        $unitPrice = $this->promotion->getUnitPrice(0);
    }
}
