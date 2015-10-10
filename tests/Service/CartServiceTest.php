<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\ShippingRate;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCartRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionProductRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionValueRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTextOptionRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCouponRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserRepository;
use LogicException;

class CartServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeCartRepository */
    protected $cartRepository;

    /** @var FakeProductRepository */
    protected $productRepository;

    /** @var FakeOptionProductRepository */
    protected $optionProductRepository;

    /** @var FakeOptionValueRepository */
    protected $optionValueRepository;

    /** @var FakeTextOptionRepository */
    protected $textOptionRepository;

    /** @var FakeCouponRepository */
    protected $couponRepository;

    /** @var FakeOrderRepository */
    protected $orderRepository;

    /** @var FakeUserRepository */
    protected $userRepository;

    /** @var CartService */
    protected $cartService;

    public function setUp()
    {
        $this->cartRepository = new FakeCartRepository;
        $this->productRepository = new FakeProductRepository;
        $this->optionProductRepository = new FakeOptionProductRepository;
        $this->optionValueRepository = new FakeOptionValueRepository;
        $this->textOptionRepository = new FakeTextOptionRepository;
        $this->couponRepository = new FakeCouponRepository;
        $this->orderRepository = new FakeOrderRepository;
        $this->userRepository = new FakeUserRepository;

        $this->setupCartService();
    }

    private function setupCartService()
    {
        $this->cartService = new CartService(
            $this->cartRepository,
            $this->productRepository,
            $this->optionProductRepository,
            $this->optionValueRepository,
            $this->textOptionRepository,
            $this->couponRepository,
            $this->orderRepository,
            $this->userRepository,
            new CartCalculator(new Pricing)
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
        $this->assertTrue($cart instanceof Cart);
    }

    public function testFindBySession()
    {
        $this->setupCartService();
        $cart = $this->cartService->findBySession('6is7ujb3crb5ja85gf91g9en62');
        $this->assertTrue($cart instanceof Cart);
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
        $this->assertTrue($coupons[0] instanceof Coupon);
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
        $this->assertTrue($cart instanceof Cart);
    }

    public function testCreateWithUser()
    {
        $cart = $this->cartService->create(1, null);
        $this->assertTrue($cart instanceof Cart);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage User or session id required
     */
    public function testCreateWithNone()
    {
        $cart = $this->cartService->create(null, null);
        $this->assertTrue($cart instanceof Cart);
    }

    public function testAddItem()
    {
        $productId = 2001;
        $quantity = 1;

        $cartItemIndex = $this->cartService->addItem($productId, $quantity);

        $cart = $this->cartService->getCartFull(1);

        $this->assertSame(0, $cartItemIndex);
        $this->assertTrue($cart->getCartItem(0) instanceof CartItem);
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
        $textOption = new TextOption;
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

        $this->assertTrue($cart->getCartItem(0) instanceof CartItem);
    }

    public function testSetters()
    {
        $cartId = 1;

        $this->cartService->setShippingRate($cartId, new ShippingRate);
        $this->cartService->setTaxRate($cartId, new TaxRate);
    }

    public function testSetUserById()
    {
        $cartId = 1;
        $userId = 1;
        $this->cartService->setUserById($cartId, $userId);

        $cart = $this->cartService->getCartFull($cartId);

        $this->assertTrue($cart->getUser() instanceof User);
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
        $cart = new Cart;
        $cart->setUser(new User);
        $cart->addCoupon(new Coupon);
        $this->cartRepository->setReturnValue($cart);
        $this->setupCartService();

        $cartId = 1;
        $payment = new CashPayment(100);
        $orderAddress = new OrderAddress;

        $order = $this->cartService->createOrder($cartId, $payment, $orderAddress);

        $this->assertTrue($order instanceof Order);
    }
}
