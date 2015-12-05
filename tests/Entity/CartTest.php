<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartTest extends DoctrineTestCase
{
    private function getPercentCoupon($id, $value)
    {
        $coupon = new Coupon;
        $coupon->setId($id);
        $coupon->setName($value . '% Off');
        $coupon->setType(AbstractPromotion::TYPE_PERCENT);
        $coupon->setValue($value);

        return $coupon;
    }

    public function testCreate()
    {
        $cartItem = new CartItem;
        $cartItem->setProduct(new Product);
        $cartItem->setQuantity(1);

        $cart = new Cart;
        $cart->setIp4('10.0.0.1');
        $cart->addCartItem($cartItem);
        $cart->addCoupon(new Coupon);
        $cart->setShipmentRate(new ShipmentRate(new Money(295, 'USD')));
        $cart->setShippingAddress(new OrderAddress);
        $cart->setTaxRate(new TaxRate);
        $cart->setSessionId('6is7ujb3crb5ja85gf91g9en62');

        $this->assertEntityValid($cart);
        $this->assertTrue($cart instanceof Cart);
        $this->assertSame('10.0.0.1', $cart->getIp4());
        $this->assertSame('6is7ujb3crb5ja85gf91g9en62', $cart->getSessionId());
        $this->assertTrue($cart->getCartitems()[0] instanceof CartItem);
        $this->assertTrue($cart->getCartitem(0) instanceof CartItem);
        $this->assertTrue($cart->getCoupons()[0] instanceof Coupon);
        $this->assertTrue($cart->getShipmentRate() instanceof ShipmentRate);
        $this->assertTrue($cart->getShippingAddress() instanceof OrderAddress);
        $this->assertTrue($cart->getTaxRate() instanceof TaxRate);
    }

    public function testAddCartItemWithDuplicate()
    {
        $cartItem1 = new CartItem;
        $cartItem1->setProduct(new Product);
        $cartItem1->setQuantity(5);

        $cartItem2 = new CartItem;
        $cartItem2->setProduct(new Product);
        $cartItem2->setQuantity(2);

        $cart = new Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        $this->assertSame(2, $cart->totalItems());
        $this->assertSame(7, $cart->totalQuantity());
    }

    public function testGetCartItemMissingThrowsException()
    {
        $cart = new Cart;

        $this->setExpectedException(
            InvalidCartActionException::class,
            'CartItem not found'
        );

        $cart->getCartItem(1);
    }

    public function testDeleteCartItem()
    {
        $cartItem = new CartItem;
        $cartItem->setProduct(new Product);
        $cartItem->setQuantity(1);

        $cart = new Cart;
        $cartItemIndex1 = $cart->addCartItem($cartItem);
        $this->assertSame(1, $cart->totalItems());

        $cart->deleteCartItem($cartItemIndex1);
        $this->assertSame(0, $cart->totalItems());
    }

    public function testDeleteCartItemMissing()
    {
        $cart = new Cart;

        $this->setExpectedException(
            InvalidCartActionException::class,
            'CartItem missing'
        );

        $cart->deleteCartItem(1);
    }

    public function testUpdateCoupon()
    {
        $coupon1 = new Coupon;
        $coupon1->setId(1);

        $coupon2 = new Coupon;
        $coupon2->setid(2);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $this->assertSame(1, $cart->getCoupons()[0]->getId());

        $cart->updateCoupon(0, $coupon2);
        $this->assertSame(2, $cart->getCoupons()[0]->getId());
    }

    public function testAddCouponWithDuplicateCouponThrowsException()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(true);

        $cart = new Cart;
        $cart->addCoupon($coupon1);

        $this->setExpectedException(
            InvalidCartActionException::class,
            'Duplicate Coupon'
        );

        $cart->addCoupon($coupon1);
    }

    public function testAddCouponWithNonStackableCouponThrowsException()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $coupon2 = $this->getPercentCoupon(2, 20);
        $coupon2->setCanCombineWithOtherCoupons(false);

        $cart = new Cart;
        $cart->addCoupon($coupon1);

        $this->setExpectedException(
            InvalidCartActionException::class,
            'Cannot stack coupon'
        );

        $cart->addCoupon($coupon2);
    }

    public function testAddCouponWithSecondStackableCouponThrowsException()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $coupon2 = $this->getPercentCoupon(2, 20);
        $coupon2->setCanCombineWithOtherCoupons(true);

        $cart = new Cart;
        $cart->addCoupon($coupon1);

        $this->setExpectedException(
            InvalidCartActionException::class,
            'Cannot stack coupon'
        );

        $cart->addCoupon($coupon2);
    }

    public function testAddCouponWithFirstStackableCouponThrowsException()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(true);

        $coupon2 = $this->getPercentCoupon(2, 20);
        $coupon2->setCanCombineWithOtherCoupons(false);

        $cart = new Cart;
        $cart->addCoupon($coupon1);

        $this->setExpectedException(
            InvalidCartActionException::class,
            'Cannot stack coupon'
        );

        $cart->addCoupon($coupon2);
    }

    public function testAddCouponWithStackableCoupons()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(true);

        $coupon2 = $this->getPercentCoupon(2, 20);
        $coupon2->setCanCombineWithOtherCoupons(true);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon2);
        $this->assertSame(2, count($cart->getCoupons()));
    }

    public function testAddNonStackableCoupon()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $this->assertSame(1, count($cart->getCoupons()));
    }

    public function testRemoveCoupon()
    {
        $cart = new Cart;
        $cart->addCoupon(new Coupon);
        $cart->removeCoupon(0);
        $this->assertSame(0, count($cart->getCoupons()));
    }

    public function testRemoveCouponMissingThrowsException()
    {
        $cart = new Cart;

        $this->setExpectedException(
            InvalidCartActionException::class,
            'Coupon missing'
        );

        $cart->removeCoupon(0);
    }

    public function testGetShippingWeight()
    {
        $product1 = new Product;
        $product1->setShippingWeight(16);

        $product2 = new Product;
        $product2->setShippingWeight(16);

        $cartItem1 = new CartItem;
        $cartItem1->setProduct($product1);
        $cartItem1->setQuantity(1);

        $cartItem2 = new CartItem;
        $cartItem2->setProduct($product2);
        $cartItem2->setQuantity(3);

        $cart = new Cart;
        $cart->addCartItem($cartItem1);
        $cart->addCartItem($cartItem2);

        $this->assertSame(64, $cart->getShippingWeight());
    }

    public function testGetTotal()
    {
        $product = new Product;
        $product->setUnitPrice(500);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $cart = new Cart;
        $cart->addCartItem($cartItem);

        $cartCalculator = new CartCalculator(new Pricing);
        $this->assertTrue($cart->getTotal($cartCalculator) instanceof CartTotal);
    }
}
