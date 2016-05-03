<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CouponTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $code = '20PCT100';
        $coupon = new Coupon($code);

        $this->assertSame(null, $coupon->getName());
        $this->assertSame($code, $coupon->getCode());
        $this->assertSame(null, $coupon->getValue());
        $this->assertSame(null, $coupon->getMinOrderValue());
        $this->assertSame(null, $coupon->getMaxOrderValue());
        $this->assertTrue($coupon->getType()->isFixed());
        $this->assertFalse($coupon->getFlagFreeShipping());
        $this->assertFalse($coupon->getCanCombineWithOtherCoupons());
    }

    public function testCreate()
    {
        $coupon = new Coupon('20PCT100');
        $coupon->setName('20% Off orders over $100');
        $coupon->setType(PromotionType::percent());
        $coupon->setValue(20);
        $coupon->setMinOrderValue(10000);
        $coupon->setMaxOrderValue(100000);
        $coupon->setFlagFreeShipping(true);
        $coupon->setCanCombineWithOtherCoupons(true);

        $this->assertEntityValid($coupon);
        $this->assertSame('20% Off orders over $100', $coupon->getName());
        $this->assertSame('20PCT100', $coupon->getCode());
        $this->assertSame(20, $coupon->getValue());
        $this->assertSame(10000, $coupon->getMinOrderValue());
        $this->assertSame(100000, $coupon->getMaxOrderValue());
        $this->assertTrue($coupon->getType()->isPercent());
        $this->assertTrue($coupon->getFlagFreeShipping());
        $this->assertTrue($coupon->getCanCombineWithOtherCoupons());
    }

    public function testIsMinOrderValueValid()
    {
        $coupon = $this->dummyData->getCoupon();
        $this->assertTrue($coupon->isMinOrderValueValid(100));

        $coupon->setMinOrderValue(100);
        $this->assertTrue($coupon->isMinOrderValueValid(100));
        $this->assertTrue($coupon->isMinOrderValueValid(200));
    }

    public function testIsMinOrderValueValidReturnsFalse()
    {
        $coupon = $this->dummyData->getCoupon();
        $coupon->setMinOrderValue(100);
        $this->assertFalse($coupon->isMinOrderValueValid(50));
    }

    public function testIsMaxOrderValueValid()
    {
        $coupon = $this->dummyData->getCoupon();
        $this->assertTrue($coupon->isMaxOrderValueValid(100));

        $coupon->setMaxOrderValue(1000);
        $this->assertTrue($coupon->isMaxOrderValueValid(1000));
        $this->assertTrue($coupon->isMaxOrderValueValid(900));
    }

    public function testIsMaxOrderValueValidReturnsFalse()
    {
        $coupon = $this->dummyData->getCoupon();
        $coupon->setMaxOrderValue(1000);
        $this->assertFalse($coupon->isMaxOrderValueValid(2000));
    }

    public function testIsValid()
    {
        $coupon = $this->dummyData->getCoupon();
        $this->assertTrue($coupon->isValid(new DateTime, 200));
    }
}
