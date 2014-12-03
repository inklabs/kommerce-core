<?php
namespace inklabs\kommerce\Entity;

class CartTotalTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $cartTotal = new CartTotal;
        $cartTotal->origSubtotal = 1;
        $cartTotal->subtotal = 1;
        $cartTotal->taxSubtotal = 1;
        $cartTotal->discount = 1;
        $cartTotal->shipping = 1;
        $cartTotal->shippingDiscount = 1;
        $cartTotal->tax = 1;
        $cartTotal->total = 1;
        $cartTotal->savings = 1;
        $cartTotal->coupons = [new Coupon];
        $cartTotal->cartPriceRules = [new CartPriceRule];
        $cartTotal->taxRate = new TaxRate;

        $this->assertInstanceOf('inklabs\kommerce\Entity\CartTotal', $cartTotal);
    }
}
