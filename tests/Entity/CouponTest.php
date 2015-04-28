<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use Symfony\Component\Validator\Validation;

class CouponTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $coupon = new Coupon;
        $coupon->setName('20% Off orders over $100');
        $coupon->setCode('20PCT100');
        $coupon->setType(Promotion::TYPE_PERCENT);
        $coupon->setValue(20);
        $coupon->setMinOrderValue(10000);
        $coupon->setMaxOrderValue(100000);
        $coupon->setFlagFreeShipping(true);
        $coupon->setCanCombineWithOtherCoupons(true);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($coupon));
        $this->assertSame('20% Off orders over $100', $coupon->getName());
        $this->assertSame('20PCT100', $coupon->getCode());
        $this->assertSame(Promotion::TYPE_PERCENT, $coupon->getType());
        $this->assertSame('Percent', $coupon->getTypeText());
        $this->assertSame(20, $coupon->getValue());
        $this->assertSame(10000, $coupon->getMinOrderValue());
        $this->assertSame(100000, $coupon->getMaxOrderValue());
        $this->assertTrue($coupon->getFlagFreeShipping());
        $this->assertTrue($coupon->getCanCombineWithOtherCoupons());
        $this->assertTrue($coupon->getView() instanceof View\Coupon);
    }

    public function testIsMinOrderValueValid()
    {
        $coupon = new Coupon;
        $this->assertTrue($coupon->isMinOrderValueValid(100));

        $coupon->setMinOrderValue(100);
        $this->assertTrue($coupon->isMinOrderValueValid(100));
        $this->assertTrue($coupon->isMinOrderValueValid(200));
    }

    public function testIsMinOrderValueValidReturnsFalse()
    {
        $coupon = new Coupon;
        $coupon->setMinOrderValue(100);
        $this->assertFalse($coupon->isMinOrderValueValid(50));
    }

    public function testIsMaxOrderValueValid()
    {
        $coupon = new Coupon;
        $this->assertTrue($coupon->isMaxOrderValueValid(100));

        $coupon->setMaxOrderValue(1000);
        $this->assertTrue($coupon->isMaxOrderValueValid(1000));
        $this->assertTrue($coupon->isMaxOrderValueValid(900));
    }

    public function testIsMaxOrderValueValidReturnsFalse()
    {
        $coupon = new Coupon;
        $coupon->setMaxOrderValue(1000);
        $this->assertFalse($coupon->isMaxOrderValueValid(2000));
    }

    public function testIsValid()
    {
        $coupon = new Coupon;
        $this->assertTrue($coupon->isValid(new \DateTime, 200));
    }
}
