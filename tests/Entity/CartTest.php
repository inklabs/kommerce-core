<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\Exception\InvalidCartActionException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;
use inklabs\kommerce\Lib\UuidInterface;

class CartTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $cart = new Cart;

        $this->assertTrue($cart->getId() instanceof UuidInterface);
        $this->assertTrue($cart->getCreated() instanceof DateTime);
        $this->assertSame(null, $cart->getSessionId());
        $this->assertSame(null, $cart->getUser());
        $this->assertSame(null, $cart->getShippingAddress());
        $this->assertSame(null, $cart->getShipmentRate());
        $this->assertSame(null, $cart->getTaxRate());
        $this->assertSame('0.0.0.0', $cart->getIp4());
        $this->assertSame(0, count($cart->getCartItems()));
        $this->assertSame(0, count($cart->getCoupons()));
    }

    public function testCreate()
    {
        $cartItem = $this->dummyData->getCartItem();
        $coupon = $this->dummyData->getCoupon();
        $shipmentRate = $this->dummyData->getShipmentRate();
        $orderAddress = $this->dummyData->getOrderAddress();
        $taxRate = $this->dummyData->getTaxRate();

        $cart = new Cart;
        $cart->setSessionId('6is7ujb3crb5ja85gf91g9en62');
        $cart->setIp4('10.0.0.1');
        $cart->addCartItem($cartItem);
        $cart->addCoupon($coupon);
        $cart->setShipmentRate($shipmentRate);
        $cart->setShippingAddress($orderAddress);
        $cart->setTaxRate($taxRate);

        $this->assertEntityValid($cart);
        $this->assertTrue($cart instanceof Cart);
        $this->assertSame('10.0.0.1', $cart->getIp4());
        $this->assertSame('6is7ujb3crb5ja85gf91g9en62', $cart->getSessionId());
        $this->assertSame($cartItem, $cart->getCartItems()[0]);
        $this->assertSame($coupon, $cart->getCoupons()[0]);
        $this->assertSame($shipmentRate, $cart->getShipmentRate());
        $this->assertSame($orderAddress, $cart->getShippingAddress());
        $this->assertSame($taxRate, $cart->getTaxRate());
    }

    public function testAddCartItemWithDuplicate()
    {
        $cart = new Cart();

        $cartItem1 = $this->dummyData->getCartItem($cart, null, 5);
        $cartItem2 = $this->dummyData->getCartItem($cart, null, 2);

        $this->assertSame(2, $cart->totalItems());
        $this->assertSame(7, $cart->totalQuantity());
    }

    public function testDeleteCartItem()
    {
        $cart = new Cart();
        $cartItem = $this->dummyData->getCartItem($cart, null, 1);

        $this->assertSame(1, $cart->totalItems());

        $cart->deleteCartItem($cartItem);

        $this->assertSame(0, $cart->totalItems());
    }

    public function testDeleteCartItemMissing()
    {
        $cart = $this->dummyData->getCart();
        $cartItem = $this->dummyData->getCartItem();

        $this->setExpectedException(
            InvalidCartActionException::class,
            'CartItem missing'
        );

        $cart->deleteCartItem($cartItem);
    }

    public function testUpdateCoupon()
    {
        $coupon1 = $this->dummyData->getCoupon();
        $coupon2 = $this->dummyData->getCoupon();

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $this->assertEntitiesEqual($coupon1, $cart->getCoupons()[0]);

        $cart->updateCoupon(0, $coupon2);
        $this->assertEntitiesEqual($coupon2, $cart->getCoupons()[0]);
    }

    public function testAddCouponWithDuplicateCouponThrowsException()
    {
        $coupon1 = $this->getPercentCoupon(20);
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
        $coupon1 = $this->getPercentCoupon(20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $coupon2 = $this->getPercentCoupon(20);
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
        $coupon1 = $this->getPercentCoupon(20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $coupon2 = $this->getPercentCoupon(20);
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
        $coupon1 = $this->getPercentCoupon(20);
        $coupon1->setCanCombineWithOtherCoupons(true);

        $coupon2 = $this->getPercentCoupon(20);
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
        $coupon1 = $this->getPercentCoupon(20);
        $coupon1->setCanCombineWithOtherCoupons(true);

        $coupon2 = $this->getPercentCoupon(20);
        $coupon2->setCanCombineWithOtherCoupons(true);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon2);
        $this->assertSame(2, count($cart->getCoupons()));
    }

    public function testAddNonStackableCoupon()
    {
        $coupon1 = $this->getPercentCoupon(20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $this->assertSame(1, count($cart->getCoupons()));
    }

    public function testRemoveCoupon()
    {
        $cart = new Cart;
        $coupon = $this->dummyData->getCoupon();
        $cart->addCoupon($coupon);
        $cart->removeCoupon($coupon);
        $this->assertCount(0, $cart->getCoupons());
    }

    public function testRemoveCouponMissingThrowsException()
    {
        $cart = new Cart;
        $coupon = $this->dummyData->getCoupon();

        $this->setExpectedException(
            InvalidCartActionException::class,
            'Coupon missing'
        );

        $cart->removeCoupon($coupon);
    }

    public function testGetShippingWeight()
    {
        $cart = new Cart();

        $cartItem1 = $this->dummyData->getCartItem($cart, null, 1);
        $cartItem1->getProduct()->setShippingWeight(16);

        $cartItem2 = $this->dummyData->getCartItem($cart, null, 3);
        $cartItem2->getProduct()->setShippingWeight(16);

        $this->assertSame(64, $cart->getShippingWeight());
    }

    public function testGetTotal()
    {
        $cart = new Cart();

        $cartItem = $this->dummyData->getCartItem($cart, null, 2);
        $cartItem->getProduct()->setUnitPrice(500);

        $cartCalculator = $this->getCartCalculator();
        $this->assertTrue($cart->getTotal($cartCalculator) instanceof CartTotal);
    }

    private function getPercentCoupon($value)
    {
        $coupon = $this->dummyData->getCoupon();
        $coupon->setName($value . '% Off');
        $coupon->setType(PromotionType::percent());
        $coupon->setValue($value);

        return $coupon;
    }
}
