<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

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

        $cartTotal = CartTotal::factory($entityCartTotal)
            ->withAllData()
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\CartTotal', $cartTotal);
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Coupon', $cartTotal->coupons[0]);
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\CartPricerule', $cartTotal->cartPriceRules[0]);
    }
}
