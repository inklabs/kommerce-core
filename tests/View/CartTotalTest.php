<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class CartTotalTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCartTotal = new Entity\CartTotal;
        $entityCartTotal->origSubtotal = 10;
        $entityCartTotal->subtotal = 10;
        $entityCartTotal->shipping = 1;
        $entityCartTotal->discount = 1;
        $entityCartTotal->tax = 1;
        $entityCartTotal->total = 7;
        $entityCartTotal->savings = 1;
        $entityCartTotal->coupons = [new Entity\Coupon];
        $entityCartTotal->cartPriceRules = [new Entity\CartPriceRule];

        $cartTotal = $entityCartTotal->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($cartTotal instanceof CartTotal);
        $this->assertTrue($cartTotal->coupons[0] instanceof Coupon);
        $this->assertTrue($cartTotal->cartPriceRules[0] instanceof CartPricerule);
    }
}
