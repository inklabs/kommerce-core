<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class CartTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCart = new Entity\Cart;
        $entityCart->addItem(new Entity\Product, 1);

        $coupon = new Entity\Coupon;
        $coupon->setId(1);
        $coupon->setType('percent');

        $entityCart->addCoupon($coupon);

        $cart = Cart::factory($entityCart)
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\CartTotal', $cart->cartTotal);
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\CartItem', $cart->items[0]);
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Coupon', $cart->coupons[0]);
    }
}
