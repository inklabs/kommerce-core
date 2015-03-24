<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Entity\Payment as Payment;

class CartNewTest extends Helper\DoctrineTestCase
{
    /* @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    /* @var \Mockery\MockInterface|Entity\Cart */
    protected $mockEntityCart;

    /* @var \Mockery\MockInterface|Lib\SessionManager */
    protected $mockSessionManager;

    /* @var \Mockery\MockInterface|Pricing */
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

    public function testAddItem()
    {
        $product = new Entity\Product;
        $product2 = new Entity\Product;

        $cart = $this->getCartServiceFullyMocked();

        $mockProductRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Product');
        $mockProductRepository
            ->shouldReceive('find')
            ->andReturn($product);
        $mockProductRepository
            ->shouldReceive('getAllProductsByIds')
            ->andReturn([$product2]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($mockProductRepository);

        $this->mockEntityCart
            ->shouldReceive('addItem')
            ->andReturn(1);

        $itemId = $cart->addItem('1', 1, ['2']);

        $this->assertSame(1, $itemId);
    }

    /**
     * @expectedException \Exception
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
     */
    public function testAddItemWithMissingProductOption()
    {
        $product = new Entity\Product;

        $cart = $this->getCartServiceFullyMocked();

        $mockProductRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Product');
        $mockProductRepository
            ->shouldReceive('find')
            ->andReturn($product);
        $mockProductRepository
            ->shouldReceive('getAllProductsByIds')
            ->andReturn(null);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($mockProductRepository);

        $itemId = $cart->addItem('1', 1, ['2']);
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
}
