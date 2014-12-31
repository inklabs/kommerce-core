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
