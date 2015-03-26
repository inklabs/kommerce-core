<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;

class CartTest extends \PHPUnit_Framework_TestCase
{
    private function getPercentCoupon($id, $value)
    {
        $coupon = new Coupon;
        $coupon->setId($id);
        $coupon->setName($value . '% Off');
        $coupon->setType(Promotion::TYPE_PERCENT);
        $coupon->setValue($value);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        return $coupon;
    }

    public function testCreateCart()
    {
        $cart = new Cart;
        $this->assertTrue($cart instanceof Cart);
        $this->assertTrue($cart->getView() instanceof View\Cart);
    }

    public function testAddItem()
    {
        $cart = new Cart;
        $itemId1 = $cart->addItem(new Product, 2);
        $itemId2 = $cart->addItem(new Product, 2, [new OptionValue(new Option)]);

        $this->assertSame(0, $itemId1);
        $this->assertSame(1, $itemId2);
        $this->assertTrue($cart->getItem(0) instanceof CartItem);
        $this->assertTrue($cart->getItem(1)->getOptionValues()[0] instanceof OptionValue);
        $this->assertSame(2, count($cart->getItems()));
    }

    public function testAddItemWithDuplicate()
    {
        $product = new Product;

        $cart = new Cart;
        $cart->addItem($product, 5);
        $cart->addItem($product, 2);

        $this->assertSame(2, $cart->totalItems());
        $this->assertSame(7, $cart->totalQuantity());
    }

    public function testGetItemMissing()
    {
        $cart = new Cart;
        $this->assertSame(null, $cart->getItem(1));
    }

    public function testDeleteItem()
    {
        $cart = new Cart;
        $itemId = $cart->addItem(new Product, 2);

        $this->assertSame(1, $cart->totalItems());
        $cart->deleteItem($itemId);
        $this->assertSame(0, $cart->totalItems());
    }

    /**
     * @expectedException \Exception
     */
    public function testDeleteItemAndItemNotFound()
    {
        $cart = new Cart;
        $cart->deleteItem(1);
    }

    public function testAddCoupon()
    {
        $cart = new Cart;
        $cart->addCoupon(new Coupon);
        $this->assertSame(1, count($cart->getCoupons()));
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
     * @expectedException \Exception
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
     * @expectedException \Exception
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
     * @expectedException \Exception
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

        $cart = new Cart;
        $cart->addItem($product1, 2);
        $cart->addItem($product2, 2);

        $this->assertSame(64, $cart->getShippingWeight());
    }

    public function testGetTotal()
    {
        $product = new Product;
        $product->setUnitPrice(500);

        $cart = new Cart;
        $cart->addItem($product, 2);
        $this->assertTrue($cart->getTotal(new Pricing) instanceof CartTotal);
    }
}
