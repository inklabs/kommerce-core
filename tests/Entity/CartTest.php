<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Pricing;
use Symfony\Component\Validator\Validation;

class CartTest extends \PHPUnit_Framework_TestCase
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
        $cart->addCartItem($cartItem);
        $cart->addCoupon(new Coupon);
        $cart->setShippingRate(new ShippingRate);
        $cart->setTaxRate(new TaxRate);
        $cart->setSessionId('6is7ujb3crb5ja85gf91g9en62');

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($cart));
        $this->assertTrue($cart instanceof Cart);
        $this->assertSame('6is7ujb3crb5ja85gf91g9en62', $cart->getSessionId());
        $this->assertTrue($cart->getCartitems()[0] instanceof CartItem);
        $this->assertTrue($cart->getCartitem(0) instanceof CartItem);
        $this->assertTrue($cart->getCoupons()[0] instanceof Coupon);
        $this->assertTrue($cart->getShippingRate() instanceof ShippingRate);
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

    public function testGetCartItemMissing()
    {
        $cart = new Cart;
        $this->assertSame(null, $cart->getCartItem(1));
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

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Item missing
     */
    public function testDeleteCartItemMissing()
    {
        $cart = new Cart;
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

    /**
     * @expectedException \inklabs\kommerce\Entity\InvalidCartActionException
     * @expectedExceptionMessage Duplicate Coupon
     */
    public function testAddCouponWithDuplicateCouponThrowsException()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(true);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon1);
    }

    /**
     * @expectedException \inklabs\kommerce\Entity\InvalidCartActionException
     * @expectedExceptionMessage Cannot stack coupon
     */
    public function testAddCouponWithNonStackableCouponThrowsException()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $coupon2 = $this->getPercentCoupon(2, 20);
        $coupon2->setCanCombineWithOtherCoupons(false);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon2);
    }

    /**
     * @expectedException \inklabs\kommerce\Entity\InvalidCartActionException
     * @expectedExceptionMessage Cannot stack coupon
     */
    public function testAddCouponWithSecondStackableCouponThrowsException()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $coupon2 = $this->getPercentCoupon(2, 20);
        $coupon2->setCanCombineWithOtherCoupons(true);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon2);
    }

    /**
     * @expectedException \inklabs\kommerce\Entity\InvalidCartActionException
     * @expectedExceptionMessage Cannot stack coupon
     */
    public function testAddCouponWithFirstStackableCouponThrowsException()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(true);

        $coupon2 = $this->getPercentCoupon(2, 20);
        $coupon2->setCanCombineWithOtherCoupons(false);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon2);
        $this->assertSame(2, count($cart->getCoupons()));
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

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Coupon missing
     */
    public function testRemoveCouponMissing()
    {
        $cart = new Cart;
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

    public function testGetOrder()
    {
        $product = new Product;
        $product->setUnitPrice(500);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);

        $cart = new Cart;
        $cart->setUser(new User);
        $cart->addCartItem($cartItem);
        $cart->addCoupon(new Coupon);
        $cart->setShippingRate(new ShippingRate);

        $order = $cart->getOrder(new CartCalculator(new Pricing));

        $this->assertTrue($order instanceof Order);
    }
}
