<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CouponTest extends EntityTestCase
{
    public function testCreate()
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
