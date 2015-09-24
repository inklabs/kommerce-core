<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class AbstractPromotionTest extends \PHPUnit_Framework_TestCase
{
    /** @var AbstractPromotion */
    protected $promotion;

    public function setUp()
    {
        $this->promotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\AbstractPromotion');
    }

    public function testCreate()
    {
        $this->promotion->setName('20% Off in 2014');
        $this->promotion->setType(AbstractPromotion::TYPE_PERCENT);
        $this->promotion->setValue(20);
        $this->promotion->setRedemptions(10);
        $this->promotion->setMaxRedemptions(100);
        $this->promotion->setReducesTaxSubtotal(true);
        $this->promotion->setStart(new \DateTime);
        $this->promotion->setEnd(new \DateTime);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($this->promotion));
        $this->assertSame('20% Off in 2014', $this->promotion->getName());
        $this->assertSame(AbstractPromotion::TYPE_PERCENT, $this->promotion->getType());
        $this->assertSame('Percent', $this->promotion->getTypeText());
        $this->assertSame(20, $this->promotion->getValue());
        $this->assertSame(10, $this->promotion->getRedemptions());
        $this->assertSame(100, $this->promotion->getMaxRedemptions());
        $this->assertSame(true, $this->promotion->getReducesTaxSubtotal());
        $this->assertTrue($this->promotion->getStart() instanceof \DateTime);
        $this->assertTrue($this->promotion->getEnd() instanceof \DateTime);
    }

    private function setDatePromotion()
    {
        $this->promotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->promotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
    }

    public function testIsDateValid()
    {
        $this->setDatePromotion();

        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($this->promotion->isDateValid(new \DateTime('2013-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($this->promotion->isDateValid(new \DateTime('2015-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsDateValidWithNullStartAndEnd()
    {
        $this->setDatePromotion();
        $this->promotion->setStart(null);
        $this->promotion->setEnd(null);

        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsDateValidWithNullStart()
    {
        $this->setDatePromotion();
        $this->promotion->setStart(null);

        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2014-02-01', new \DateTimeZone('UTC'))));
        $this->assertTrue($this->promotion->isDateValid(new \DateTime('2013-02-01', new \DateTimeZone('UTC'))));
        $this->assertFalse($this->promotion->isDateValid(new \DateTime('2015-02-01', new \DateTimeZone('UTC'))));
    }

    public function testIsDateValidWithNullEnd()
    {
        $this->setDatePromotion();
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

        $this->promotion->setRedemptions(9);
        $this->assertTrue($this->promotion->isRedemptionCountValid());

        $this->promotion->setRedemptions(10);
        $this->assertFalse($this->promotion->isRedemptionCountValid());

        $this->promotion->setRedemptions(15);
        $this->assertFalse($this->promotion->isRedemptionCountValid());
    }

    public function testIsValid()
    {
        $this->promotion->setMaxRedemptions(null);
        $this->assertTrue($this->promotion->isValidPromotion(new \DateTime));
    }

    public function testGetUnitPriceWithPercent()
    {
        $this->promotion->setType(AbstractPromotion::TYPE_PERCENT);
        $this->promotion->setValue(20);
        $this->assertSame(800, $this->promotion->getUnitPrice(1000));
    }

    public function testGetUnitPriceWithFixed()
    {
        $this->promotion->setType(AbstractPromotion::TYPE_FIXED);
        $this->promotion->setValue(20);
        $this->assertSame(980, $this->promotion->getUnitPrice(1000));
    }

    public function testGetUnitPriceWithExact()
    {
        $this->promotion->setType(AbstractPromotion::TYPE_EXACT);
        $this->promotion->setValue(20);
        $this->assertSame(20, $this->promotion->getUnitPrice(1000));
    }

    /**
     * @expectedException \Exception
     */
    public function testGetUnitPriceWithInvalidType()
    {
        $this->promotion->setType(-1);
        $this->promotion->getUnitPrice(0);
    }
}
