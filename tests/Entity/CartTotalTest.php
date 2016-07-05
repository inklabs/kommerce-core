<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CartTotalTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $cartTotal = new CartTotal;

        $this->assertSame(0, $cartTotal->origSubtotal);
        $this->assertSame(0, $cartTotal->subtotal);
        $this->assertSame(0, $cartTotal->taxSubtotal);
        $this->assertSame(0, $cartTotal->discount);
        $this->assertSame(0, $cartTotal->shipping);
        $this->assertSame(0, $cartTotal->shippingDiscount);
        $this->assertSame(0, $cartTotal->tax);
        $this->assertSame(0, $cartTotal->total);
        $this->assertSame(0, $cartTotal->savings);
        $this->assertSame(null, $cartTotal->taxRate);
        $this->assertSame(0, count($cartTotal->coupons));
        $this->assertSame(0, count($cartTotal->getCartPriceRules()));
    }

    public function testCreate()
    {
        $coupon = $this->dummyData->getCoupon();
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $taxRate = $this->dummyData->getTaxRate();

        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 1;
        $cartTotal->subtotal = 2;
        $cartTotal->taxSubtotal = 3;
        $cartTotal->discount = 4;
        $cartTotal->shipping = 5;
        $cartTotal->shippingDiscount = 6;
        $cartTotal->tax = 7;
        $cartTotal->total = 8;
        $cartTotal->savings = 9;
        $cartTotal->coupons = [$coupon];
        $cartTotal->addCartPriceRule($cartPriceRule);
        $cartTotal->taxRate = $taxRate;

        $this->assertTrue($cartTotal instanceof CartTotal);
        $this->assertSame(1, $cartTotal->origSubtotal);
        $this->assertSame(2, $cartTotal->subtotal);
        $this->assertSame(3, $cartTotal->taxSubtotal);
        $this->assertSame(4, $cartTotal->discount);
        $this->assertSame(5, $cartTotal->shipping);
        $this->assertSame(6, $cartTotal->shippingDiscount);
        $this->assertSame(7, $cartTotal->tax);
        $this->assertSame(8, $cartTotal->total);
        $this->assertSame(9, $cartTotal->savings);
        $this->assertSame($taxRate, $cartTotal->taxRate);
        $this->assertSame($coupon, $cartTotal->coupons[0]);
        $this->assertSame($cartPriceRule, $cartTotal->getCartPriceRules()[0]);
    }
}
