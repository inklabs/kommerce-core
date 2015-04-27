<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Service;
use Symfony\Component\Validator\Validation;

class CartTest extends \PHPUnit_Framework_TestCase
{
    private function getPercentCoupon($id, $value)
    {
        $coupon = new Coupon;
        $coupon->setId($id);
        $coupon->setName($value . '% Off');
        $coupon->setType(Promotion::TYPE_PERCENT);
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

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($cart));
        $this->assertTrue($cart instanceof Cart);
        $this->assertTrue($cart->getCartitems()[0] instanceof CartItem);
        $this->assertTrue($cart->getCartitem(0) instanceof CartItem);
        $this->assertTrue($cart->getCoupons()[0] instanceof Coupon);
        $this->assertTrue($cart->getView() instanceof View\Cart);
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
     * @expectedException \LogicException
     * @expectedExceptionMessage Unable to add coupon
     */
    public function testAddCouponWithNonStackableCoupon()
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
     * @expectedException \LogicException
     * @expectedExceptionMessage Unable to add coupon
     */
    public function testAddCouponWithDuplicateCoupon()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(true);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon1);
    }

    public function testAddCouponWithSecondStackableCoupon()
    {
        $coupon1 = $this->getPercentCoupon(1, 20);
        $coupon1->setCanCombineWithOtherCoupons(false);

        $coupon2 = $this->getPercentCoupon(2, 20);
        $coupon2->setCanCombineWithOtherCoupons(true);

        $cart = new Cart;
        $cart->addCoupon($coupon1);
        $cart->addCoupon($coupon2);
        $this->assertSame(2, count($cart->getCoupons()));
    }

    public function testAddCouponWithFirstStackableCoupon()
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
        $this->assertTrue($cart->getTotal(new Service\Pricing) instanceof CartTotal);
    }

    public function testGetOrder()
    {
        $product = new Product;
        $product->setUnitPrice(500);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);

        $cart = new Cart;
        $cart->addCartItem($cartItem);

        $order = $cart->getOrder(new Service\Pricing);

        $this->assertTrue($order instanceof Order);
    }
}
