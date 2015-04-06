<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Entity\Payment as Payment;

class CartNewTest extends Helper\DoctrineTestCase
{
    /** @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    /** @var \Mockery\MockInterface|Entity\Cart */
    protected $mockEntityCart;

    /** @var \Mockery\MockInterface|Lib\SessionManager */
    protected $mockSessionManager;

    /** @var \Mockery\MockInterface|Pricing */
    protected $mockPricing;

    public function setUp()
    {
        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
        $this->mockPricing = \Mockery::mock('inklabs\kommerce\Service\Pricing');

        $this->mockSessionManager = \Mockery::mock('inklabs\kommerce\Lib\ArraySessionManager');
        $this->mockSessionManager
            ->shouldReceive('set')
            ->andReturn(null);

        $this->mockEntityCart = \Mockery::mock('inklabs\kommerce\Entity\Cart');

        $this->mockEntityCart
            ->shouldReceive('getItems')
            ->once()
            ->andReturnUndefined();
        $this->mockEntityCart
            ->shouldReceive('getCoupons')
            ->once()
            ->andReturnUndefined();
    }

    /**
     * @return Cart
     */
    protected function getCartServiceFullyMocked()
    {
        $this->mockSessionManager
            ->shouldReceive('get')
            ->andReturn($this->mockEntityCart);

        return new Cart($this->mockEntityManager, $this->mockPricing, $this->mockSessionManager);
    }

    public function testCreate()
    {
        $product = $this->getDummyProduct();
        $coupon = $this->getDummyCoupon();

        $this->entityManager->persist($product);
        $this->entityManager->persist($coupon);
        $this->entityManager->flush();

        $viewProduct = $product->getView()->export();

        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $cart->setShippingRate(new Entity\Shipping\FedexRate);
        $cart->setTaxRate(new Entity\TaxRate);
        $cart->setUser(new Entity\User);
        $cart->addCouponByCode($coupon->getCode());
        $itemId1 = $cart->addItem($viewProduct->encodedId, 1);
        $itemId2 = $cart->addItem($viewProduct->encodedId, 1);
        $cart->updateQuantity($itemId1, 2);
        $cart->deleteItem($itemId2);
        $this->assertSame(1, $cart->totalItems());
        $this->assertSame(2, $cart->totalQuantity());
        $this->assertSame(32, $cart->getShippingWeight());
        $this->assertSame(2, $cart->getShippingWeightInPounds());
        $this->assertTrue($cart->getTotal() instanceof Entity\CartTotal);
        $this->assertTrue($cart->getCoupons()[0] instanceof Entity\Coupon);
        $this->assertTrue($cart->getItems()[0] instanceof Entity\View\CartItem);
        $this->assertTrue($cart->getItem(0) instanceof Entity\View\CartItem);
        $this->assertTrue($cart->getProducts()[0] instanceof Entity\View\Product);
        $this->assertTrue($cart->getView() instanceof Entity\View\Cart);
    }

    public function testAddItem()
    {
        $cart = $this->getCartServiceFullyMocked();

        $mockProductRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Product');
        $mockProductRepository
            ->shouldReceive('find')
            ->andReturn(new Entity\Product);
        $mockProductRepository
            ->shouldReceive('getAllProductsByIds')
            ->andReturn([new Entity\Product]);

        $mockOptionValueRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\OptionValue');
        $mockOptionValueRepository
            ->shouldReceive('getAllOptionValuesByIds')
            ->andReturn([new Entity\OptionValue(new Entity\Option)]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->once()
            ->andReturn($mockProductRepository);
        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->once()
            ->andReturn($mockOptionValueRepository);

        $this->mockEntityCart
            ->shouldReceive('addItem')
            ->andReturn(1);

        $itemId = $cart->addItem('1', 1, ['1' => '2']);

        $this->assertSame(1, $itemId);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Product not found
     */
    public function testAddItemWithMissingProduct()
    {
        $product = new Entity\Product;

        $cart = $this->getCartServiceFullyMocked();

        $mockProductRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Product');
        $mockProductRepository
            ->shouldReceive('find')
            ->andReturn(null);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($mockProductRepository);

        $itemId = $cart->addItem('1', 1);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Option not found
     */
    public function testAddItemWithMissingOptions()
    {
        $cart = $this->getCartServiceFullyMocked();

        $mockProductRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Product');
        $mockProductRepository
            ->shouldReceive('find')
            ->andReturn(new Entity\Product);
        $mockProductRepository
            ->shouldReceive('getAllProductsByIds')
            ->andReturn([new Entity\Product]);

        $mockOptionValueRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\OptionValue');
        $mockOptionValueRepository
            ->shouldReceive('getAllOptionValuesByIds')
            ->andReturn([]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->once()
            ->andReturn($mockProductRepository);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->once()
            ->andReturn($mockOptionValueRepository);

        $this->mockEntityCart
            ->shouldReceive('addItem')
            ->andReturn(1);

        $itemId = $cart->addItem('1', 1, ['1' => '2']);
    }

    public function testAddCouponByCode()
    {
        $cart = $this->getCartServiceFullyMocked();

        $mockCouponRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Coupon');
        $mockCouponRepository
            ->shouldReceive('findOneByCode')
            ->andReturn(new Entity\Coupon);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($mockCouponRepository);

        $this->mockEntityCart
            ->shouldReceive('addCoupon')
            ->andReturn(1);

        $couponId = $cart->addCouponByCode('coupon-code');
        $this->assertSame(1, $couponId);
    }

    /**
     * @expectedException \Exception
     */
    public function testAddCouponByCodeWithMissingCoupon()
    {
        $cart = $this->getCartServiceFullyMocked();

        $mockCouponRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Coupon');
        $mockCouponRepository
            ->shouldReceive('findOneByCode')
            ->andReturn(null);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($mockCouponRepository);

        $couponId = $cart->addCouponByCode('coupon-code');
    }

    public function testRemoveCoupon()
    {
        $cart = $this->getCartServiceFullyMocked();

        $this->mockEntityCart
            ->shouldReceive('removeCoupon')
            ->andReturn(null);

        $cart->removeCoupon(1);
    }

    /**
     * @expectedException \Exception
     */
    public function testRemoveCouponThrowsException()
    {
        $cart = $this->getCartServiceFullyMocked();

        $this->mockEntityCart
            ->shouldReceive('removeCoupon')
            ->andThrow(new \Exception);

        $cart->removeCoupon(1);
    }

    public function testGetCoupons()
    {
        $this->mockEntityCart
            ->shouldReceive('getCoupons')
            ->andReturn([new Entity\Coupon]);

        $cart = $this->getCartServiceFullyMocked();

        $coupons = $cart->getCoupons();
        $this->assertTrue($coupons[0] instanceof Entity\Coupon);
    }

    public function testUpdateQuantity()
    {
        $cart = $this->getCartServiceFullyMocked();

        $mockCartItem = \Mockery::mock('inklabs\kommerce\Entity\CartItem');
        $mockCartItem
            ->shouldReceive('setQuantity')
            ->andReturnUndefined();

        $this->mockEntityCart
            ->shouldReceive('getItem')
            ->andReturn($mockCartItem);

        $cart->updateQuantity(1, 2);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateQuantityWithMissingItem()
    {
        $cart = $this->getCartServiceFullyMocked();

        $this->mockEntityCart
            ->shouldReceive('getItem')
            ->andReturn(null);

        $cart->updateQuantity(1, 2);
    }

    public function testDeleteItem()
    {
        $cart = $this->getCartServiceFullyMocked();

        $this->mockEntityCart
            ->shouldReceive('deleteItem')
            ->andReturnUndefined();

        $cart->deleteItem(1);
    }

    /**
     * @expectedException \Exception
     */
    public function testDeleteItemWithMissingItem()
    {
        $cart = $this->getCartServiceFullyMocked();

        $this->mockEntityCart
            ->shouldReceive('deleteItem')
            ->andThrow(new \Exception);

        $cart->deleteItem(1);
    }

    public function testGetItems()
    {
        $cart = $this->getCartServiceFullyMocked();

        $mockCartItemView = \Mockery::mock('inklabs\kommerce\Entity\View\CartItem');
        $mockCartItemView
            ->shouldReceive('withAllData')
            ->andReturnSelf();
        $mockCartItemView
            ->shouldReceive('export')
            ->andReturnSelf();

        $mockCartItem = \Mockery::mock('inklabs\kommerce\Entity\CartItem');
        $mockCartItem
            ->shouldReceive('getView')
            ->andReturn($mockCartItemView);

        $this->mockEntityCart
            ->shouldReceive('getItems')
            ->andReturn([$mockCartItem]);

        $items = $cart->getItems();
        $this->assertTrue($items[0] instanceof Entity\View\CartItem);
    }

    public function testGetProducts()
    {
        $cart = $this->getCartServiceFullyMocked();

        $mockViewProduct = \Mockery::mock('inklabs\kommerce\Entity\View\Product');

        $mockCartItemView = \Mockery::mock('inklabs\kommerce\Entity\View\CartItem');
        $mockCartItemView
            ->shouldReceive('withAllData')
            ->andReturnSelf();
        $mockCartItemView
            ->shouldReceive('export')
            ->andReturnSelf();
        $mockCartItemView
            ->product = $mockViewProduct;

        $mockCartItem = \Mockery::mock('inklabs\kommerce\Entity\CartItem');
        $mockCartItem
            ->shouldReceive('getView')
            ->andReturn($mockCartItemView);

        $this->mockEntityCart
            ->shouldReceive('getItems')
            ->andReturn([$mockCartItem]);

        $products = $cart->getProducts();
        $this->assertTrue($products[0] instanceof Entity\View\Product);
    }

    public function testGetItem()
    {
        $cart = $this->getCartServiceFullyMocked();

        $mockCartItemView = \Mockery::mock('inklabs\kommerce\Entity\View\CartItem');
        $mockCartItemView
            ->shouldReceive('withAllData')
            ->andReturnSelf();
        $mockCartItemView
            ->shouldReceive('export')
            ->andReturnSelf();

        $mockCartItem = \Mockery::mock('inklabs\kommerce\Entity\CartItem');
        $mockCartItem
            ->shouldReceive('getView')
            ->andReturn($mockCartItemView);

        $this->mockEntityCart
            ->shouldReceive('getItem')
            ->andReturn($mockCartItem);

        $item = $cart->getItem(1);
        $this->assertTrue($item instanceof Entity\View\CartItem);
    }

    public function testGetItemReturnsNull()
    {
        $cart = $this->getCartServiceFullyMocked();

        $this->mockEntityCart
            ->shouldReceive('getItem')
            ->andReturn(null);

        $item = $cart->getItem(1);
        $this->assertSame(null, $item);
    }

    public function testCartPersistence()
    {
        $sessionManager = new Lib\ArraySessionManager;

        $coupon = $this->getDummyCoupon();
        $product = $this->getDummyProduct();
        $product2 = $this->getDummyProduct();

        $option = $this->getDummyOption();
        $optionValue = $this->getDummyOptionValue($option);
        $optionValue->setProduct($product2);

        $this->entityManager->persist($coupon);
        $this->entityManager->persist($product);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($option);
        $this->entityManager->persist($optionValue);
        $this->entityManager->flush();

        $viewProduct = $product->getView()->export();
        $viewOptionValue = $optionValue->getView()->withOption()->export();

        $optionValueEncodedIds = [
            $viewOptionValue->option->encodedId => $viewOptionValue->encodedId
        ];

        $cart = new Cart($this->entityManager, new Pricing, $sessionManager);
        $cart->addCouponByCode($coupon->getCode());
        $this->assertSame(0, $cart->totalItems());

        $itemId1 = $cart->addItem($viewProduct->encodedId, 1, $optionValueEncodedIds);
        $this->assertSame(1, $cart->totalItems());
        $this->assertSame(20, $cart->getCoupons()[0]->getValue());
        $this->assertSame(1200, $cart->getItem($itemId1)->product->unitPrice);
        $this->assertSame(1200, $cart->getItem($itemId1)->optionValues[0]->product->unitPrice);

        // Make changes to test persistence
        $coupon->setValue(10);
        $product->setUnitPrice(501);
        $product2->setUnitPrice(501);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $cart = new Cart($this->entityManager, new Pricing, $sessionManager);
        $this->assertSame(1, $cart->totalItems());
        $this->assertSame(10, $cart->getCoupons()[0]->getValue());
        $this->assertSame(501, $cart->getItem($itemId1)->product->unitPrice);
        $this->assertSame(501, $cart->getItem($itemId1)->optionValues[0]->product->unitPrice);
    }

    /**
     * @expectedException \Exception
     */
    public function testAddItemMissing()
    {
        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $cart->addItem('xxx', 1);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateQuantityAndItemNotFound()
    {
        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $cart->updateQuantity(1, 2);
    }

    /**
     * @expectedException \Exception
     */
    public function testDeleteItemAndItemNotFound()
    {
        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $cart->deleteItem(1);
    }

    /**
     * @expectedException \Exception
     */
    public function testAddCouponMissing()
    {
        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $cart->addCouponByCode('xxx');
    }

    public function testDeleteCoupon()
    {
        $coupon = $this->getDummyCoupon();

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();

        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $couponId = $cart->addCouponByCode($coupon->getCode());
        $this->assertSame(1, count($cart->getCoupons()));

        $cart->removeCoupon($couponId);

        $this->assertSame(0, count($cart->getCoupons()));
    }

    public function testCreateOrder()
    {
        $product = $this->getDummyProduct();
        $coupon = $this->getDummyCoupon();
        $user = $this->getDummyUser();

        $this->entityManager->persist($coupon);
        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $viewProduct = $product->getView()->export();

        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $itemId1 = $cart->addItem($viewProduct->encodedId, 4);
        $cart->addCouponByCode($coupon->getCode());
        $cart->setUser($user);

        $shippingAddress = $this->getDummyOrderAddress();
        $order = $cart->createOrder(new Payment\Cash(1600), $shippingAddress);

        $this->assertTrue($order instanceof Entity\Order);
        $this->assertSame(1, $order->getId());
    }
}
