<?php
namespace inklabs\kommerce\Entity;

class PromotionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $promotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Promotion');
        $promotion->setid(1);
        $promotion->setName('20% Off in 2014');
        $promotion->setType('percent');
        $promotion->setValue(20);
        $promotion->setRedemptions(10);
        $promotion->setMaxRedemptions(100);
        $promotion->setReducesTaxSubtotal(true);
        $promotion->setStart(new \DateTime);
        $promotion->setEnd(new \DateTime);

        $this->assertSame(1, $promotion->getId());
        $this->assertSame('20% Off in 2014', $promotion->getName());
        $this->assertSame('percent', $promotion->getType());
        $this->assertSame(20, $promotion->getValue());
        $this->assertSame(10, $promotion->getRedemptions());
        $this->assertSame(100, $promotion->getMaxRedemptions());
        $this->assertSame(true, $promotion->getReducesTaxSubtotal());
        $this->assertTrue($promotion->getStart() instanceof \DateTime);
        $this->assertTrue($promotion->getEnd() instanceof \DateTime);
    }

    private function getDatePromotion()
    {
        $promotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Promotion');
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
        $promotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Promotion');
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
        $promotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Promotion');

        $promotion->setMaxRedemptions(null);
        $this->assertTrue($promotion->isValidPromotion(new \DateTime));
    }

    public function testGetUnitPriceWithPercent()
    {
        $promotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Promotion');

        $promotion->setType('percent');
        $promotion->setValue(20);
        $this->assertSame(800, $promotion->getUnitPrice(1000));
    }

    public function testGetUnitPriceWithFixed()
    {
        $promotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Promotion');

        $promotion->setType('fixed');
        $promotion->setValue(20);
        $this->assertSame(980, $promotion->getUnitPrice(1000));
    }

    public function testGetUnitPriceWithExact()
    {
        $promotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Promotion');

        $promotion->setType('exact');
        $promotion->setValue(20);
        $this->assertSame(20, $promotion->getUnitPrice(1000));
    }

    /**
     * @expectedException \Exception
     */
    public function testGetUnitPriceWithInvalidType()
    {
        $promotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Promotion');

        $promotion->setType('invalid');
        $promotion->getUnitPrice(0);
    }
}
