<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class CartTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCart = new Entity\Cart;
        $entityCart->addCartItem(new Entity\Product, 1);

        $coupon = new Entity\Coupon;
        $coupon->setType(Entity\Promotion::TYPE_PERCENT);

        $entityCart->addCoupon($coupon);

        $cart = $entityCart->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($cart->cartTotal instanceof CartTotal);
        $this->assertTrue($cart->items[0] instanceof CartItem);
        $this->assertTrue($cart->coupons[0] instanceof Coupon);
    }
}
