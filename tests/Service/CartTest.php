<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\Entity\Payment;
use inklabs\kommerce\tests\EntityRepository\FakeCart;
use inklabs\kommerce\tests\EntityRepository\FakeProduct;
use inklabs\kommerce\tests\EntityRepository\FakeOptionProduct;
use inklabs\kommerce\tests\EntityRepository\FakeOptionValue;
use inklabs\kommerce\tests\EntityRepository\FakeTextOption;
use inklabs\kommerce\tests\EntityRepository\FakeCoupon;
use inklabs\kommerce\tests\EntityRepository\FakeOrder;
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

        $this->setupCartService();
    }

    private function setupCartService()
    {
        $cartId = 1;
        $this->cartService = new Cart(
            $this->cartRepository,
            $this->productRepository,
            $this->optionProductRepository,
            $this->optionValueRepository,
            $this->textOptionRepository,
            $this->couponRepository,
            $this->orderRepository,
            new Lib\Pricing,
            $cartId
        );
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Cart not found
     */
    public function testCreateThrowsException()
    {
        $this->cartRepository->setReturnValue(null);

        $this->setupCartService();
    }

    public function testAddCouponByCode()
    {
        $couponIndex = $this->cartService->addCouponByCode('code');
        $this->assertSame(0, $couponIndex);
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage Coupon not found
     */
    public function testAddCouponByCodeMissing()
    {
        $this->couponRepository->setReturnValue(null);
        $couponIndex = $this->cartService->addCouponByCode('code');
    }

    public function testGetCoupons()
    {
        $couponIndex = $this->cartService->addCouponByCode('code');

        $coupons = $this->cartService->getCoupons();
        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }

    public function testRemoveCoupon()
    {
        $couponIndex = $this->cartService->addCouponByCode('code');

        $coupons = $this->cartService->getCoupons();
        $this->assertSame(1, count($coupons));

        $this->cartService->removeCoupon($couponIndex);

        $coupons = $this->cartService->getCoupons();
        $this->assertSame(0, count($coupons));
    }

    public function testAddItem()
    {
        $productId = 2001;
        $quantity = 1;

        $cartItemIndex = $this->cartService->addItem($productId, $quantity);

        $cartItem = $this->cartService->getItem($cartItemIndex);

        $this->assertSame(0, $cartItemIndex);
        $this->assertTrue($cartItem instanceof View\CartItem);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Product not found
     */
    public function testAddItemWithMissingProduct()
    {
        $this->productRepository->setReturnValue(null);
        $productId = 2001;

        $cartItemIndex = $this->cartService->addItem($productId);
    }

    public function testAddItemOptionProducts()
    {
        $productId = 2001;
        $cartItemIndex = $this->cartService->addItem($productId);

        $optionProductIds = [101];

        $this->cartService->addItemOptionProducts($cartItemIndex, $optionProductIds);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Cart Item not found
     */
    public function testAddItemOptionProductsThrowsException()
    {
        $cartItemIndex = 1;
        $optionProductIds = [101];

        $this->cartService->addItemOptionProducts($cartItemIndex, $optionProductIds);
    }

    public function testAddItemOptionValues()
    {
        $productId = 2001;
        $cartItemIndex = $this->cartService->addItem($productId);

        $optionValueIds = [201];

        $this->cartService->addItemOptionValues($cartItemIndex, $optionValueIds);
    }

    public function testAddItemTextOptionValues()
    {
        $textOption = new Entity\TextOption;
        $textOption->setId(301);
        $this->textOptionRepository->setReturnValue($textOption);

        $productId = 2001;
        $cartItemIndex = $this->cartService->addItem($productId);

        $textOptionValues = [$textOption->getId() => 'Happy Birthday'];

        $this->cartService->addItemTextOptionValues($cartItemIndex, $textOptionValues);
    }

    public function testUpdateQuantity()
    {
        $productId = 2001;
        $cartItemIndex = $this->cartService->addItem($productId);

        $quantity = 2;
        $this->cartService->updateQuantity($cartItemIndex, $quantity);

        $cartItem = $this->cartService->getItem($cartItemIndex);

        $this->assertSame(2, $cartItem->quantity);
    }

    public function testDeleteItem()
    {
        $productId = 2001;
        $cartItemIndex = $this->cartService->addItem($productId);

        $this->cartService->deleteItem($cartItemIndex);

        $cartItem = $this->cartService->getItem($cartItemIndex);

        $this->assertSame(null, $cartItem);
    }

    public function testGetItems()
    {
        $productId = 2001;
        $cartItemIndex = $this->cartService->addItem($productId);

        $cartItems = $this->cartService->getItems();

        $this->assertTrue($cartItems[0] instanceof View\CartItem);
    }

    public function testGetProducts()
    {
        $productId = 2001;
        $cartItemIndex = $this->cartService->addItem($productId);

        $cartProducts = $this->cartService->getProducts();

        $this->assertTrue($cartProducts[0] instanceof View\Product);
    }

    public function testGetters()
    {
        $product = new Entity\Product;
        $product->setShippingWeight(16);
        $this->productRepository->setReturnValue($product);

        $productId = 2001;
        $cartItemIndex = $this->cartService->addItem($productId, 2);

        $this->assertSame(32, $this->cartService->getShippingWeight());
        $this->assertSame(2, $this->cartService->getShippingWeightInPounds());
        $this->assertSame(1, $this->cartService->totalItems());
        $this->assertSame(2, $this->cartService->totalQuantity());
        $this->assertTrue($this->cartService->getTotal() instanceof Entity\CartTotal);
        $this->assertTrue($this->cartService->getView() instanceof View\Cart);
    }

    public function testSetters()
    {
        $this->cartService->setShippingRate(new Entity\Shipping\Rate);
        $this->cartService->setTaxRate(new Entity\TaxRate);
        $this->cartService->setUser(new Entity\User);
    }

    public function testAddOrder()
    {
        $cart = new Entity\Cart;
        $cart->setUser(new Entity\User);
        $cart->addCoupon(new Entity\Coupon);
        $this->cartRepository->setReturnValue($cart);
        $this->setupCartService();

        $payment = new Entity\Payment\Cash(100);
        $orderAddress = new Entity\OrderAddress;

        $order = $this->cartService->createOrder($payment, $orderAddress);

        $this->assertTrue($order instanceof Entity\Order);
    }
}
