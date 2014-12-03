<?php
namespace inklabs\kommerce\Entity;

class PromotionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $promotion = new Promotion;
        $promotion->setid(1);
        $promotion->setName('20% Off in 2014');
        $promotion->setType('percent');
        $promotion->setValue(20);
        $promotion->setRedemptions(10);
        $promotion->setMaxRedemptions(100);
        $promotion->setReducesTaxSubtotal(true);
        $promotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $promotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->assertEquals(1, $promotion->getId());
        $this->assertEquals('20% Off in 2014', $promotion->getName());
        $this->assertEquals('percent', $promotion->getType());
        $this->assertEquals(20, $promotion->getValue());
        $this->assertEquals(10, $promotion->getRedemptions());
        $this->assertEquals(100, $promotion->getMaxRedemptions());
        $this->assertEquals(true, $promotion->getReducesTaxSubtotal());
        $this->assertEquals(new \DateTime('2014-01-01', new \DateTimeZone('UTC')), $promotion->getStart());
        $this->assertEquals(new \DateTime('2014-12-31', new \DateTimeZone('UTC')), $promotion->getEnd());
    }

    private function getDatePromotion()
    {
        $promotion = new Promotion;
        $promotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $promotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        return $promotion;
    }

    public function testIsDateValid()
    {
        $promotion = $this->getDatePromotion();

        $this->assertTrue($promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($promotion->isDateValid(new \DateTime('2013-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($promotion->isDateValid(new \DateTime('2015-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsDateValidWithNullStartAndEnd()
    {
        $promotion = $this->getDatePromotion();
        $promotion->setStart(null);
        $promotion->setEnd(null);

        $this->assertTrue($promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsDateValidWithNullStart()
    {
        $promotion = $this->getDatePromotion();
        $promotion->setStart(null);

        $this->assertTrue($promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
        $this->assertTrue($promotion->isDateValid(new \DateTime('2013-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($promotion->isDateValid(new \DateTime('2015-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsDateValidWithNullEnd()
    {
        $promotion = $this->getDatePromotion();
        $promotion->setEnd(null);

        $this->assertTrue($promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($promotion->isDateValid(new \DateTime('2013-02-01', new \DateTimeZone('UTC'))));
        $this->assertTrue($promotion->isDateValid(new \DateTime('2015-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsRedemptionCountValid()
    {
        $promotion = new Promotion;
        $promotion->setMaxRedemptions(null);
        $this->assertTrue($promotion->isRedemptionCountValid());

        $promotion->setMaxRedemptions(10);
        $promotion->setRedemptions(0);
        $this->assertTrue($promotion->isRedemptionCountValid());

        $promotion->setRedemptions(9);
        $this->assertTrue($promotion->isRedemptionCountValid());

        $promotion->setRedemptions(10);
        $this->assertFalse($promotion->isRedemptionCountValid());

        $promotion->setRedemptions(15);
        $this->assertFalse($promotion->isRedemptionCountValid());
    }

    public function testIsValid()
    {
        $promotion = new Promotion;
        $promotion->setMaxRedemptions(null);
        $this->assertTrue($promotion->isValidPromotion(new \DateTime));
    }

    public function testGetUnitPriceWithPercent()
    {
        $promotion = new Promotion;
        $promotion->setType('percent');
        $promotion->setValue(20);
        $this->assertEquals(800, $promotion->getUnitPrice(1000));
    }

    public function testGetUnitPriceWithFixed()
    {
        $promotion = new Promotion;
        $promotion->setType('fixed');
        $promotion->setValue(20);
        $this->assertEquals(980, $promotion->getUnitPrice(1000));
    }

    public function testGetUnitPriceWithExact()
    {
        $promotion = new Promotion;
        $promotion->setType('exact');
        $promotion->setValue(20);
        $this->assertEquals(20, $promotion->getUnitPrice(1000));
    }

    /**
     * @expectedException \Exception
     */
    public function testGetUnitPriceWithInvalidType()
    {
        $promotion = new Promotion;
        $promotion->setType('invalid');
        $promotion->getUnitPrice(0);
    }
}
