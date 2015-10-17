<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CashPayment;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ShippingRate;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCartRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionProductRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionValueRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTextOptionRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCouponRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserRepository;

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

    /** @var CartCalculator */
    protected $cartCalculator;

    /** @var FakeEventDispatcher */
    protected $eventDispatcher;

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
        $this->cartCalculator = new CartCalculator(new Pricing);
        $this->eventDispatcher = new FakeEventDispatcher;

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
            $this->cartCalculator,
            $this->eventDispatcher
        );
    }

    public function testFindByUser()
    {
        $cart = $this->cartService->findByUser(1);
        $this->assertTrue($cart instanceof Cart);
    }

    public function testFindBySession()
    {
        $cart = $this->cartService->findBySession('6is7ujb3crb5ja85gf91g9en62');
        $this->assertTrue($cart instanceof Cart);
    }

    public function testAddCouponByCode()
    {
        $coupon = new Coupon;
        $coupon->setCode('20PCT');
        $this->couponRepository->create($coupon);
        $this->cartRepository->create(new Cart);

        $couponIndex = $this->cartService->addCouponByCode(1, $coupon->getCode());
        $this->assertSame(0, $couponIndex);
    }

    /**
     * @expectedException \inklabs\kommerce\EntityRepository\EntityNotFoundException
     * @expectedExceptionMessage  Coupon not found
     */
    public function testAddCouponByCodeMissingThrowsException()
    {
        $this->cartService->addCouponByCode(1, 'code');
    }

    public function testGetCoupons()
    {
        $coupon = new Coupon;
        $coupon->setCode('20PCT');
        $this->couponRepository->create($coupon);

        $cart = new Cart;
        $this->cartRepository->create($cart);
        $couponIndex = $this->cartService->addCouponByCode($cart->getId(), $coupon->getCode());

        $coupons = $this->cartService->getCoupons($cart->getId());
        $this->assertTrue($coupons[0] instanceof Coupon);
    }

    public function testRemoveCart()
    {
        $this->cartRepository->create(new Cart);
        $this->cartService->removeCart(1);
    }

    public function testRemoveCoupon()
    {
        $coupon = new Coupon;
        $coupon->setCode('20PCT');
        $this->couponRepository->create($coupon);

        $this->cartRepository->create(new Cart);
        $couponIndex = $this->cartService->addCouponByCode(1, $coupon->getCode());

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
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

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
        $quantity = 1;

        $product = new Product;
        $product->setId(2001);

        $this->cartRepository->create(new Cart);
        $this->productRepository->create($product);

        $cartItemIndex = $this->cartService->addItem($product->getId(), $quantity);

        $cart = $this->cartService->findOneById(1);

        $this->assertSame(0, $cartItemIndex);
        $this->assertTrue($cart->getCartItem(0) instanceof CartItem);
    }

    /**
     * @expectedException \inklabs\kommerce\EntityRepository\EntityNotFoundException
     * @expectedExceptionMessage Product not found
     */
    public function testAddItemWithMissingProductThrowsException()
    {
        $this->productRepository->setReturnValue(null);

        $cartId = 1;
        $productId = 2001;
        $this->cartService->addItem($cartId, $productId);
    }

    public function testAddItemOptionProducts()
    {
        $cartId = 1;
        $optionProductIds = [101];

        $product = new Product;
        $product->setId(2001);

        $this->cartRepository->create(new Cart);
        $this->productRepository->create($product);

        $cartItemIndex = $this->cartService->addItem($cartId, $product->getId());
        $this->cartService->addItemOptionProducts($cartId, $cartItemIndex, $optionProductIds);
    }

    /**
     * @expectedException \inklabs\kommerce\Entity\InvalidCartActionException
     * @expectedExceptionMessage CartItem not found
     */
    public function testAddItemOptionProductsThrowsException()
    {
        $cartId = 1;
        $cartItemIndex = 1;
        $optionProductIds = [101];

        $this->cartRepository->create(new Cart);

        $this->cartService->addItemOptionProducts($cartId, $cartItemIndex, $optionProductIds);
    }

    public function testAddItemOptionValues()
    {
        $cartId = 1;
        $optionValueIds = [201];

        $product = new Product;
        $product->setId(2001);

        $this->cartRepository->create(new Cart);
        $this->productRepository->create($product);

        $cartItemIndex = $this->cartService->addItem($cartId, $product->getId());
        $this->cartService->addItemOptionValues($cartId, $cartItemIndex, $optionValueIds);
    }

    public function testAddItemTextOptionValues()
    {
        $textOption = new TextOption;
        $textOption->setId(301);
        $this->textOptionRepository->setReturnValue($textOption);

        $cartId = 1;
        $textOptionValues = [$textOption->getId() => 'Happy Birthday'];

        $product = new Product;
        $product->setId(2001);

        $this->cartRepository->create(new Cart);
        $this->productRepository->create($product);

        $cartItemIndex = $this->cartService->addItem($cartId, $product->getId());
        $this->cartService->addItemTextOptionValues($cartId, $cartItemIndex, $textOptionValues);
    }

    public function testCopyCartItems()
    {
        $fromCart = $this->dummyData->getCart([$this->dummyData->getCartItemFull()]);
        $this->cartRepository->create($fromCart);

        $toCart = $this->dummyData->getCart();
        $this->cartRepository->create($toCart);

        $this->cartService->copyCartItems($fromCart->getId(), $toCart->getId());
    }

    public function testUpdateQuantity()
    {
        $cartId = 1;
        $quantity = 2;

        $product = new Product;
        $product->setId(2001);

        $this->cartRepository->create(new Cart);
        $this->productRepository->create($product);

        $cartItemIndex = $this->cartService->addItem($cartId, $product->getId());

        $this->cartService->updateQuantity($cartId, $cartItemIndex, $quantity);

        $cart = $this->cartService->findOneById($cartId);

        $this->assertSame(2, $cart->getCartItem(0)->getQuantity());
    }

    public function testDeleteItem()
    {
        $cartId = 1;

        $product = new Product;
        $product->setId(2001);

        $this->cartRepository->create(new Cart);
        $this->productRepository->create($product);

        $cartItemIndex = $this->cartService->addItem($cartId, $product->getId());

        $this->cartService->deleteItem($cartId, $cartItemIndex);

        $cart = $this->cartService->findOneById($cartId);

        $this->assertSame(0, count($cart->getCartItems()));
    }

    public function testGetItems()
    {
        $cartId = 1;

        $product = new Product;
        $product->setId(2001);

        $this->cartRepository->create(new Cart);
        $this->productRepository->create($product);

        $this->cartService->addItem($cartId, $product->getId());

        $cart = $this->cartService->findOneById($cartId);

        $this->assertTrue($cart->getCartItem(0) instanceof CartItem);
    }

    public function testSetters()
    {
        $cartId = 1;

        $this->cartRepository->create(new Cart);

        $this->cartService->setShippingRate($cartId, new ShippingRate);
        $this->cartService->setTaxRate($cartId, new TaxRate);
    }

    public function testSetUserById()
    {
        $cart = new Cart;
        $this->cartRepository->create($cart);

        $user = new User;
        $this->userRepository->create($user);

        $this->cartService->setUserById($cart->getId(), $user->getId());

        $cart = $this->cartService->findOneById($cart->getId());

        $this->assertTrue($cart->getUser() instanceof User);
    }

    public function testSetSessionId()
    {
        $sessionId = '6is7ujb3crb5ja85gf91g9en62';

        $cart = new Cart;
        $this->cartRepository->create($cart);

        $this->cartService->setSessionId($cart->getId(), $sessionId);

        $this->cartService->findOneById($cart->getId());
    }

    /**
     * @expectedException \inklabs\kommerce\EntityRepository\EntityNotFoundException
     * @expectedExceptionMessage User not found
     */
    public function testSetUserWithMissingUserThrowsException()
    {
        $this->cartService->setUserById(1, 1);
    }

    public function testCreateOrder()
    {
        $cart = new Cart;
        $user = new User;
        $cart->setUser($user);
        $cart->addCoupon(new Coupon);

        $this->userRepository->create($user);
        $this->cartRepository->create($cart);

        $payment = new CashPayment(100);
        $orderAddress = new OrderAddress;

        $order = $this->cartService->createOrder(
            $cart->getId(),
            $payment,
            $orderAddress
        );

        $this->assertTrue($order instanceof Order);
        $this->assertTrue($this->eventDispatcher->wasDispatchCalled());
    }
}
