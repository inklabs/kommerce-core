<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class CartTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $coupon = new Entity\Coupon;
        $coupon->setId(1);
        $coupon->setType(Entity\Promotion::TYPE_PERCENT);

        $cartItem= new Entity\CartItem;
        $cartItem->setProduct(new Entity\Product);
        $cartItem->setQuantity(1);

        $cart = new Entity\Cart;
        $cart->addCartItem($cartItem);
        $cart->addCoupon($coupon);

        $viewCart = $cart->getView()
            ->withAllData(new Service\Pricing)
            ->export();

        $this->assertTrue($viewCart->cartTotal instanceof CartTotal);
        $this->assertTrue($viewCart->cartItems[0] instanceof CartItem);
        $this->assertTrue($viewCart->coupons[0] instanceof Coupon);
    }
}
