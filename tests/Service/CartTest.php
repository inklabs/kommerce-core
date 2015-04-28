<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\Entity\Payment;
use inklabs\kommerce\tests\EntityRepository\FakeCart;
use inklabs\kommerce\tests\EntityRepository\FakeCoupon;
use LogicException;

class CartTest extends Helper\DoctrineTestCase
{
    /** @var FakeCart */
    protected $cartRepository;

    /** @var FakeCoupon */
    protected $couponRepository;

    /** @var Cart */
    protected $cartService;

    public function setUp()
    {
        $this->cartRepository = new FakeCart;
        $this->couponRepository = new FakeCoupon;
        $this->cartService = new Cart(
            $this->cartRepository,
            $this->couponRepository,
            new Service\Pricing
        );
    }

    public function testFind()
    {
        $cart = $this->cartService->find(1);
        $this->assertTrue($cart instanceof View\Cart);
    }

    public function testFindMissing()
    {
        $this->cartRepository->setReturnValue(null);

        $cart = $this->cartService->find(0);
        $this->assertSame(null, $cart);
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
        $couponIndex = $this->cartService->addCouponByCode(1, 'code');
    }

    public function testGetCoupons()
    {
        $cart = new Entity\Cart;
        $cart->addCoupon(new Entity\Coupon);
        $this->cartRepository->setReturnValue($cart);

        $coupons = $this->cartService->getCoupons(1);
        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }

//    /**
//     * @return Cart
//     */
//    protected function getCartServiceFullyMocked()
//    {
//        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
//        $this->mockPricing = \Mockery::mock('inklabs\kommerce\Service\Pricing');
//
//        $this->mockEntityCart = \Mockery::mock('inklabs\kommerce\Entity\Cart');
//
//        $this->mockEntityCart
//            ->shouldReceive('getItems')
//            ->once()
//            ->andReturnUndefined();
//
//        $this->mockEntityCart
//            ->shouldReceive('getCoupons')
//            ->once()
//            ->andReturnUndefined();
//
//        $this->mockSessionManager = \Mockery::mock('inklabs\kommerce\Lib\ArraySessionManager');
//        $this->mockSessionManager
//            ->shouldReceive('set')
//            ->andReturn(null);
//
//        $this->mockSessionManager
//            ->shouldReceive('get')
//            ->andReturn($this->mockEntityCart);
//
//        return new Cart($this->mockEntityManager, $this->mockPricing, $this->mockSessionManager);
//    }
//
//    public function testCreate()
//    {
//        $product = $this->getDummyProduct();
//        $coupon = $this->getDummyCoupon();
//
//        $this->entityManager->persist($product);
//        $this->entityManager->persist($coupon);
//        $this->entityManager->flush();
//
//        $viewProduct = $product->getView()->export();
//
//        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
//        $cart->setShippingRate(new Entity\Shipping\FedexRate);
//        $cart->setTaxRate(new Entity\TaxRate);
//        $cart->setUser(new Entity\User);
//        $cart->addCouponByCode($coupon->getCode());
//        $itemId1 = $cart->addItem($viewProduct->encodedId, 1);
//        $itemId2 = $cart->addItem($viewProduct->encodedId, 1);
//        $cart->updateQuantity($itemId1, 2);
//        $cart->deleteItem($itemId2);
//        $this->assertSame(1, $cart->totalItems());
//        $this->assertSame(2, $cart->totalQuantity());
//        $this->assertSame(32, $cart->getShippingWeight());
//        $this->assertSame(2, $cart->getShippingWeightInPounds());
//        $this->assertTrue($cart->getTotal() instanceof Entity\CartTotal);
//        $this->assertTrue($cart->getCoupons()[0] instanceof Entity\Coupon);
//        $this->assertTrue($cart->getItems()[0] instanceof View\CartItem);
//        $this->assertTrue($cart->getItem(0) instanceof View\CartItem);
//        $this->assertTrue($cart->getProducts()[0] instanceof View\Product);
//        $this->assertTrue($cart->getView() instanceof View\Cart);
//    }
//
//    public function testAddItem()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $mockProductRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Product');
//        $mockProductRepository
//            ->shouldReceive('find')
//            ->andReturn(new Entity\Product);
//        $mockProductRepository
//            ->shouldReceive('getAllProductsByIds')
//            ->andReturn([new Entity\Product]);
//
//        $mockOptionValueRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\OptionValue');
//        $mockOptionValueRepository
//            ->shouldReceive('getAllOptionValuesByIds')
//            ->andReturn([new Entity\Product(new Entity\Product, new Entity\Product)]);
//
//        $this->mockEntityManager
//            ->shouldReceive('getRepository')
//            ->once()
//            ->andReturn($mockProductRepository);
//        $this->mockEntityManager
//            ->shouldReceive('getRepository')
//            ->once()
//            ->andReturn($mockOptionValueRepository);
//
//        $this->mockEntityCart
//            ->shouldReceive('addOrderItem')
//            ->andReturn(1);
//
//        $itemId = $cart->addItem('1', 1, ['1' => '2']);
//
//        $this->assertSame(1, $itemId);
//    }
//
//    /**
//     * @expectedException \Exception
//     * @expectedExceptionMessage Product not found
//     */
//    public function testAddItemWithMissingProduct()
//    {
//        $product = new Entity\Product;
//
//        $cart = $this->getCartServiceFullyMocked();
//
//        $mockProductRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Product');
//        $mockProductRepository
//            ->shouldReceive('find')
//            ->andReturn(null);
//
//        $this->mockEntityManager
//            ->shouldReceive('getRepository')
//            ->andReturn($mockProductRepository);
//
//        $itemId = $cart->addItem('1', 1);
//    }
//
//    /**
//     * @expectedException \Exception
//     * @expectedExceptionMessage Option not found
//     */
//    public function testAddItemWithMissingOptions()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $mockProductRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Product');
//        $mockProductRepository
//            ->shouldReceive('find')
//            ->andReturn(new Entity\Product);
//        $mockProductRepository
//            ->shouldReceive('getAllProductsByIds')
//            ->andReturn([new Entity\Product]);
//
//        $mockOptionValueRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\OptionValue');
//        $mockOptionValueRepository
//            ->shouldReceive('getAllOptionValuesByIds')
//            ->andReturn([]);
//
//        $this->mockEntityManager
//            ->shouldReceive('getRepository')
//            ->once()
//            ->andReturn($mockProductRepository);
//
//        $this->mockEntityManager
//            ->shouldReceive('getRepository')
//            ->once()
//            ->andReturn($mockOptionValueRepository);
//
//        $this->mockEntityCart
//            ->shouldReceive('addOrderItem')
//            ->andReturn(1);
//
//        $itemId = $cart->addItem('1', 1, ['1' => '2']);
//    }
//
//    /**
//     * @expectedException \Exception
//     */
//    public function testAddCouponByCodeWithMissingCoupon()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $mockCouponRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Coupon');
//        $mockCouponRepository
//            ->shouldReceive('findOneByCode')
//            ->andReturn(null);
//
//        $this->mockEntityManager
//            ->shouldReceive('getRepository')
//            ->andReturn($mockCouponRepository);
//
//        $couponId = $cart->addCouponByCode('coupon-code');
//    }
//
//    public function testRemoveCoupon()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $this->mockEntityCart
//            ->shouldReceive('removeCoupon')
//            ->andReturn(null);
//
//        $cart->removeCoupon(1);
//    }
//
//    /**
//     * @expectedException \Exception
//     */
//    public function testRemoveCouponThrowsException()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $this->mockEntityCart
//            ->shouldReceive('removeCoupon')
//            ->andThrow(new \Exception);
//
//        $cart->removeCoupon(1);
//    }
//
//    public function testGetCoupons()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $this->mockEntityCart
//            ->shouldReceive('getCoupons')
//            ->andReturn([new Entity\Coupon]);
//
//        $coupons = $cart->getCoupons();
//        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
//    }
//
//    public function testUpdateQuantity()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $mockCartItem = \Mockery::mock('inklabs\kommerce\Entity\CartItem');
//        $mockCartItem
//            ->shouldReceive('setQuantity')
//            ->andReturnUndefined();
//
//        $this->mockEntityCart
//            ->shouldReceive('getOrderItem')
//            ->andReturn($mockCartItem);
//
//        $cart->updateQuantity(1, 2);
//    }
//
//    /**
//     * @expectedException \Exception
//     */
//    public function testUpdateQuantityWithMissingItem()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $this->mockEntityCart
//            ->shouldReceive('getOrderItem')
//            ->andReturn(null);
//
//        $cart->updateQuantity(1, 2);
//    }
//
//    public function testDeleteItem()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $this->mockEntityCart
//            ->shouldReceive('deleteCartItem')
//            ->andReturnUndefined();
//
//        $cart->deleteItem(1);
//    }
//
//    /**
//     * @expectedException \Exception
//     */
//    public function testDeleteItemWithMissingItem()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $this->mockEntityCart
//            ->shouldReceive('deleteCartItem')
//            ->andThrow(new \Exception);
//
//        $cart->deleteItem(1);
//    }
//
//    public function testGetItems()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $mockCartItemView = \Mockery::mock('inklabs\kommerce\View\CartItem');
//        $mockCartItemView
//            ->shouldReceive('withAllData')
//            ->andReturnSelf();
//        $mockCartItemView
//            ->shouldReceive('export')
//            ->andReturnSelf();
//
//        $mockCartItem = \Mockery::mock('inklabs\kommerce\Entity\CartItem');
//        $mockCartItem
//            ->shouldReceive('getView')
//            ->andReturn($mockCartItemView);
//
//        $this->mockEntityCart
//            ->shouldReceive('getItems')
//            ->andReturn([$mockCartItem]);
//
//        $items = $cart->getItems();
//        $this->assertTrue($items[0] instanceof View\CartItem);
//    }
//
//    public function testGetProducts()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $mockViewProduct = \Mockery::mock('inklabs\kommerce\View\Product');
//
//        $mockCartItemView = \Mockery::mock('inklabs\kommerce\View\CartItem');
//        $mockCartItemView
//            ->shouldReceive('withAllData')
//            ->andReturnSelf();
//        $mockCartItemView
//            ->shouldReceive('export')
//            ->andReturnSelf();
//        $mockCartItemView
//            ->product = $mockViewProduct;
//
//        $mockCartItem = \Mockery::mock('inklabs\kommerce\Entity\CartItem');
//        $mockCartItem
//            ->shouldReceive('getView')
//            ->andReturn($mockCartItemView);
//
//        $this->mockEntityCart
//            ->shouldReceive('getItems')
//            ->andReturn([$mockCartItem]);
//
//        $products = $cart->getProducts();
//        $this->assertTrue($products[0] instanceof View\Product);
//    }
//
//    public function testGetItem()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $mockCartItemView = \Mockery::mock('inklabs\kommerce\View\CartItem');
//        $mockCartItemView
//            ->shouldReceive('withAllData')
//            ->andReturnSelf();
//        $mockCartItemView
//            ->shouldReceive('export')
//            ->andReturnSelf();
//
//        $mockCartItem = \Mockery::mock('inklabs\kommerce\Entity\CartItem');
//        $mockCartItem
//            ->shouldReceive('getView')
//            ->andReturn($mockCartItemView);
//
//        $this->mockEntityCart
//            ->shouldReceive('getOrderItem')
//            ->andReturn($mockCartItem);
//
//        $item = $cart->getItem(1);
//        $this->assertTrue($item instanceof View\CartItem);
//    }
//
//    public function testGetItemReturnsNull()
//    {
//        $cart = $this->getCartServiceFullyMocked();
//
//        $this->mockEntityCart
//            ->shouldReceive('getOrderItem')
//            ->andReturn(null);
//
//        $item = $cart->getItem(1);
//        $this->assertSame(null, $item);
//    }
//
//    public function xtestCartPersistence()
//    {
//        $sessionManager = new Lib\ArraySessionManager;
//
//        $coupon = $this->getDummyCoupon();
//        $product = $this->getDummyProduct();
//        $product2 = $this->getDummyProduct();
//        $optionTypeProduct = $this->getDummyOption();
//        $optionValueProduct = $this->getDummyOptionProduct($optionTypeProduct, $product2);
//
//        $this->entityManager->persist($coupon);
//        $this->entityManager->persist($product);
//        $this->entityManager->persist($product2);
//        $this->entityManager->persist($optionTypeProduct);
//        $this->entityManager->persist($optionValueProduct);
//        $this->entityManager->flush();
//
//        $viewProduct = $product->getView()
//            ->export();
//
//        $viewOptionValue = $optionValueProduct->getView()
//            ->withOptionType()
//            ->export();
//
//        $optionValueEncodedIds = [
//            $viewOptionValue->optionType->encodedId => $viewOptionValue->encodedId
//        ];
//
//        $cart = new Cart($this->entityManager, new Pricing, $sessionManager);
//        $cart->addCouponByCode($coupon->getCode());
//        $this->assertSame(0, $cart->totalItems());
//
//        $itemId1 = $cart->addItem($viewProduct->encodedId, 1, $optionValueEncodedIds);
//        $this->assertSame(1, $cart->totalItems());
//        $this->assertSame(20, $cart->getCoupons()[0]->getValue());
//        $this->assertSame(1200, $cart->getItem($itemId1)->product->unitPrice);
//        $this->assertSame(1200, $cart->getItem($itemId1)->optionValues[0]->product->unitPrice);
//
//        // Make changes to test persistence
//        $coupon->setValue(10);
//        $product->setUnitPrice(501);
//        $product2->setUnitPrice(501);
//        $this->entityManager->flush();
//        $this->entityManager->clear();
//
//        $cart = new Cart($this->entityManager, new Pricing, $sessionManager);
//        $this->assertSame(1, $cart->totalItems());
//        $this->assertSame(10, $cart->getCoupons()[0]->getValue());
//        $this->assertSame(501, $cart->getItem($itemId1)->product->unitPrice);
//        $this->assertSame(501, $cart->getItem($itemId1)->optionValues[0]->product->unitPrice);
//    }
//
//    /**
//     * @expectedException \Exception
//     */
//    public function testAddItemMissing()
//    {
//        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
//        $cart->addItem('xxx', 1);
//    }
//
//    /**
//     * @expectedException \Exception
//     */
//    public function testUpdateQuantityAndItemNotFound()
//    {
//        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
//        $cart->updateQuantity(1, 2);
//    }
//
//    /**
//     * @expectedException \Exception
//     */
//    public function testDeleteItemAndItemNotFound()
//    {
//        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
//        $cart->deleteItem(1);
//    }
//
//    /**
//     * @expectedException \Exception
//     */
//    public function testAddCouponMissing()
//    {
//        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
//        $cart->addCouponByCode('xxx');
//    }
//
//    public function testDeleteCoupon()
//    {
//        $coupon = $this->getDummyCoupon();
//
//        $this->entityManager->persist($coupon);
//        $this->entityManager->flush();
//
//        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
//        $couponId = $cart->addCouponByCode($coupon->getCode());
//        $this->assertSame(1, count($cart->getCoupons()));
//
//        $cart->removeCoupon($couponId);
//
//        $this->assertSame(0, count($cart->getCoupons()));
//    }
//
//    public function testCreateOrder()
//    {
//        $product = $this->getDummyProduct();
//        $coupon = $this->getDummyCoupon();
//        $user = $this->getDummyUser();
//
//        $this->entityManager->persist($coupon);
//        $this->entityManager->persist($product);
//        $this->entityManager->persist($user);
//        $this->entityManager->flush();
//
//        $viewProduct = $product->getView()->export();
//
//        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
//        $itemId1 = $cart->addItem($viewProduct->encodedId, 4);
//        $cart->addCouponByCode($coupon->getCode());
//        $cart->setUser($user);
//
//        $shippingAddress = $this->getDummyOrderAddress();
//        $order = $cart->createOrder(new Payment\Cash(1600), $shippingAddress);
//
//        $this->assertTrue($order instanceof Entity\Order);
//        $this->assertSame(1, $order->getId());
//    }
//
//    public function testClearCart()
//    {
//        $product = $this->getDummyProduct();
//
//        $this->entityManager->persist($product);
//        $this->entityManager->flush();
//
//        $viewProduct = $product->getView()->export();
//
//        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
//        $itemId1 = $cart->addItem($viewProduct->encodedId, 4);
//        $this->assertSame(1, $cart->totalItems());
//
//        $cart->clear();
//
//        $this->assertSame(0, $cart->totalItems());
//    }
}
