<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class CartTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $coupon = new Entity\Coupon;
        $coupon->setId(1);
        $coupon->setType(Entity\AbstractPromotion::TYPE_PERCENT);

        $cartItem= new Entity\CartItem;
        $cartItem->setProduct(new Entity\Product);
        $cartItem->setQuantity(1);

        $cart = new Entity\Cart;
        $cart->addCartItem($cartItem);
        $cart->addCoupon($coupon);
        $cart->setShippingRate(new Entity\ShippingRate);
        $cart->setTaxRate(new Entity\TaxRate);
        $cart->setuser(new Entity\User);

        $viewCart = $cart->getView()
            ->withAllData(new Lib\CartCalculator(new Lib\Pricing))
            ->export();

        $this->assertTrue($viewCart->cartTotal instanceof CartTotal);
        $this->assertTrue($viewCart->cartItems[0] instanceof CartItem);
        $this->assertTrue($viewCart->coupons[0] instanceof Coupon);
        $this->assertTrue($viewCart->shippingRate instanceof ShippingRate);
        $this->assertTrue($viewCart->taxRate instanceof TaxRate);
        $this->assertTrue($viewCart->user instanceof User);
    }
}
