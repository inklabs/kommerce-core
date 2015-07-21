<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\Entity\Payment;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCart;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProduct;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionProduct;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionValue;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTextOption;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCoupon;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrder;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUser;
use LogicException;

class CartTest extends Helper\DoctrineTestCase
{
    /** @var FakeCart */
    protected $cartRepository;

    /** @var FakeProduct */
    protected $productRepository;

    /** @var FakeOptionProduct */
    protected $optionProductRepository;

    /** @var FakeOptionValue */
    protected $optionValueRepository;

    /** @var FakeTextOption */
    protected $textOptionRepository;

    /** @var FakeCoupon */
    protected $couponRepository;

    /** @var FakeOrder */
    protected $orderRepository;

    /** @var FakeUser */
    protected $userRepository;

    /** @var Cart */
    protected $cartService;

    public function setUp()
    {
        $this->cartRepository = new FakeCart;
        $this->productRepository = new FakeProduct;
        $this->optionProductRepository = new FakeOptionProduct;
        $this->optionValueRepository = new FakeOptionValue;
        $this->textOptionRepository = new FakeTextOption;
        $this->couponRepository = new FakeCoupon;
        $this->orderRepository = new FakeOrder;
        $this->userRepository = new FakeUser;

        $this->setupCartService();
    }

    private function setupCartService()
    {
        $this->cartService = new Cart(
            $this->cartRepository,
            $this->productRepository,
            $this->optionProductRepository,
            $this->optionValueRepository,
            $this->textOptionRepository,
            $this->couponRepository,
            $this->orderRepository,
            $this->userRepository,
            new Lib\CartCalculator(new Lib\Pricing)
        );
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Cart not found
     */
    public function testGetCartAndThrowExceptionIfCartNotFoundThrowsException()
    {
        $this->cartRepository->setReturnValue(null);
        $this->setupCartService();
        $this->cartService->getCartFull(1);
    }

    public function testFindByUser()
    {
        $this->setupCartService();
        $cart = $this->cartService->findByUser(1);
        $this->assertTrue($cart instanceof Entity\Cart);
    }

    public function testFindBySession()
    {
        $this->setupCartService();
        $cart = $this->cartService->findBySession('6is7ujb3crb5ja85gf91g9en62');
        $this->assertTrue($cart instanceof Entity\Cart);
    }

    public function testAddCouponByCode()
    {
        $couponIndex = $this->cartService->addCouponByCode(1, 'code');
        $this->assertSame(0, $couponIndex);
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage Coupon not found
     */
    public function testAddCouponByCodeMissing()
    {
        $this->couponRepository->setReturnValue(null);
        $this->cartService->addCouponByCode(1, 'code');
    }

    public function testGetCoupons()
    {
        $couponIndex = $this->cartService->addCouponByCode(1, 'code');

        $coupons = $this->cartService->getCoupons($couponIndex);
        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }

    public function testRemoveCart()
    {
        $this->cartService->removeCart(1);
    }

    public function testRemoveCoupon()
    {
        $couponIndex = $this->cartService->addCouponByCode(1, 'code');

        $coupons = $this->cartService->getCoupons(1);
        $this->assertSame(1, count($coupons));

        $this->cartService->removeCoupon(1, $couponIndex);

        $coupons = $this->cartService->getCoupons(1);
        $this->assertSame(0, count($coupons));
    }

    public function testCreateWithSession()
    {
        $cart = $this->cartService->create(null, '6is7ujb3crb5ja85gf91g9en62');
        $this->assertTrue($cart instanceof Entity\Cart);
    }

    public function testCreateWithUser()
    {
        $cart = $this->cartService->create(1, null);
        $this->assertTrue($cart instanceof Entity\Cart);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage User or session id required
     */
    public function testCreateWithNone()
    {
        $cart = $this->cartService->create(null, null);
        $this->assertTrue($cart instanceof Entity\Cart);
    }

    public function testAddItem()
    {
        $productId = 2001;
        $quantity = 1;

        $cartItemIndex = $this->cartService->addItem($productId, $quantity);

        $cart = $this->cartService->getCartFull(1);

        $this->assertSame(0, $cartItemIndex);
        $this->assertTrue($cart->getCartItem(0) instanceof Entity\CartItem);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Product not found
     */
    public function testAddItemWithMissingProduct()
    {
        $this->productRepository->setReturnValue(null);

        $cartId = 1;
        $productId = 2001;
        $this->cartService->addItem($cartId, $productId);
    }

    public function testAddItemOptionProducts()
    {
        $cartId = 1;
        $productId = 2001;
        $optionProductIds = [101];

        $cartItemIndex = $this->cartService->addItem($cartId, $productId);
        $this->cartService->addItemOptionProducts($cartId, $cartItemIndex, $optionProductIds);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Cart Item not found
     */
    public function testAddItemOptionProductsThrowsException()
    {
        $cartId = 1;
        $cartItemIndex = 1;
        $optionProductIds = [101];

        $this->cartService->addItemOptionProducts($cartId, $cartItemIndex, $optionProductIds);
    }

    public function testAddItemOptionValues()
    {
        $cartId = 1;
        $productId = 2001;
        $optionValueIds = [201];

        $cartItemIndex = $this->cartService->addItem($cartId, $productId);
        $this->cartService->addItemOptionValues($cartId, $cartItemIndex, $optionValueIds);
    }

    public function testAddItemTextOptionValues()
    {
        $textOption = new Entity\TextOption;
        $textOption->setId(301);
        $this->textOptionRepository->setReturnValue($textOption);

        $cartId = 1;
        $productId = 2001;
        $textOptionValues = [$textOption->getId() => 'Happy Birthday'];

        $cartItemIndex = $this->cartService->addItem($cartId, $productId);
        $this->cartService->addItemTextOptionValues($cartId, $cartItemIndex, $textOptionValues);
    }

    public function testCopyCartItems()
    {
        $fromCart = $this->getDummyCart([$this->getDummyFullCartItem()]);
        $this->cartRepository->save($fromCart);

        $toCart = $this->getDummyCart();
        $this->cartRepository->save($toCart);

        $this->cartRepository->setReturnValue($fromCart);
        $this->cartService->copyCartItems($fromCart->getId(), $toCart->getId());
    }

    public function testUpdateQuantity()
    {
        $cartId = 1;
        $productId = 2001;
        $quantity = 2;

        $cartItemIndex = $this->cartService->addItem($cartId, $productId);

        $this->cartService->updateQuantity($cartId, $cartItemIndex, $quantity);

        $cart = $this->cartService->getCartFull($cartId);

        $this->assertSame(2, $cart->getCartItem(0)->getQuantity());
    }

    public function testDeleteItem()
    {
        $cartId = 1;
        $productId = 2001;
        $cartItemIndex = $this->cartService->addItem($cartId, $productId);

        $this->cartService->deleteItem($cartId, $cartItemIndex);

        $cart = $this->cartService->getCartFull($cartId);

        $this->assertSame(0, count($cart->getCartItems()));
    }

    public function testGetItems()
    {
        $cartId = 1;
        $productId = 2001;
        $this->cartService->addItem($cartId, $productId);

        $cart = $this->cartService->getCartFull($cartId);

        $this->assertTrue($cart->getCartItem(0) instanceof Entity\CartItem);
    }

    public function testSetters()
    {
        $cartId = 1;

        $this->cartService->setShippingRate($cartId, new Entity\ShippingRate);
        $this->cartService->setTaxRate($cartId, new Entity\TaxRate);
    }

    public function testSetUserById()
    {
        $cartId = 1;
        $userId = 1;
        $this->cartService->setUserById($cartId, $userId);

        $cart = $this->cartService->getCartFull($cartId);

        $this->assertTrue($cart->getUser() instanceof Entity\User);
    }

    public function testSetSessionId()
    {
        $cartId = 1;
        $sessionId = '6is7ujb3crb5ja85gf91g9en62';
        $this->cartService->setSessionId($cartId, $sessionId);

        $this->cartService->getCartFull($cartId);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage User not found
     */
    public function testSetUserWithMissingUser()
    {
        $this->userRepository->setReturnValue(null);

        $cartId = 1;
        $userId = 1;
        $this->cartService->setUserById($cartId, $userId);
    }

    public function testAddOrder()
    {
        $cart = new Entity\Cart;
        $cart->setUser(new Entity\User);
        $cart->addCoupon(new Entity\Coupon);
        $this->cartRepository->setReturnValue($cart);
        $this->setupCartService();

        $cartId = 1;
        $payment = new Entity\Payment\Cash(100);
        $orderAddress = new Entity\OrderAddress;

        $order = $this->cartService->createOrder($cartId, $payment, $orderAddress);

        $this->assertTrue($order instanceof Entity\Order);
    }
}
