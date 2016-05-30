<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeInventoryTransactionRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionProductRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionValueRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTaxRateRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTextOptionRepository;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class CartServiceTest extends ServiceTestCase
{
    /** @var CartService */
    protected $cartService;

    /** @var CartCalculator */
    protected $cartCalculator;

    /** @var CartRepositoryInterface | \Mockery\Mock */
    protected $cartRepository;

    /** @var CouponRepositoryInterface | \Mockery\Mock */
    protected $couponRepository;

    /** @var FakeEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var FakeOptionProductRepository */
    protected $optionProductRepository;

    /** @var FakeOptionValueRepository */
    protected $optionValueRepository;

    /** @var OrderRepositoryInterface | \Mockery\Mock */
    protected $orderRepository;

    /** @var ProductRepositoryInterface | \Mockery\Mock */
    protected $productRepository;

    /** @var FakeShipmentGateway */
    protected $fakeShipmentGateway;

    /** @var FakeTaxRateRepository */
    protected $taxRateRepository;

    /** @var FakeTextOptionRepository */
    protected $textOptionRepository;

    /** @var UserRepositoryInterface | \Mockery\Mock */
    protected $userRepository;

    /** @var InventoryLocationRepositoryInterface */
    protected $inventoryLocationRepository;

    /** @var  InventoryTransactionRepositoryInterface */
    protected $inventoryTransactionRepository;

    /** @var InventoryServiceInterface */
    protected $inventoryService;

    public function setUp()
    {
        parent::setUp();

        $this->cartCalculator = new CartCalculator(new Pricing);
        $this->cartRepository = $this->mockRepository->getCartRepository();
        $this->couponRepository = $this->mockRepository->getCouponRepository();
        $this->fakeEventDispatcher = new FakeEventDispatcher;
        $this->productRepository = $this->mockRepository->getProductRepository();
        $this->optionProductRepository = new FakeOptionProductRepository;
        $this->optionValueRepository = new FakeOptionValueRepository;
        $this->orderRepository = $this->mockRepository->getOrderRepository();
        $this->fakeShipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);
        $this->taxRateRepository = new FakeTaxRateRepository;
        $this->textOptionRepository = new FakeTextOptionRepository;
        $this->userRepository = $this->mockRepository->getUserRepository();
        $this->inventoryLocationRepository = $this->mockRepository->getInventoryLocationRepository();
        $this->inventoryTransactionRepository = new FakeInventoryTransactionRepository;

        $customerHoldInventoryLocation = $this->dummyData->getInventoryLocation();
        $customerHoldInventoryLocation->setName('Hold For Customer Order');
        $customerHoldInventoryLocation->setCode('CUSTOMER-HOLD');

        $this->inventoryService = new InventoryService(
            $this->inventoryLocationRepository,
            $this->inventoryTransactionRepository,
            $customerHoldInventoryLocation->getId()
        );

        $this->setupCartService();
    }

    private function setupCartService()
    {
        $this->cartService = new CartService(
            $this->cartRepository,
            $this->couponRepository,
            $this->fakeEventDispatcher,
            $this->optionProductRepository,
            $this->optionValueRepository,
            $this->orderRepository,
            $this->productRepository,
            $this->fakeShipmentGateway,
            $this->taxRateRepository,
            $this->textOptionRepository,
            $this->userRepository,
            $this->inventoryService
        );
    }

    public function testFindOneByUser()
    {
        $user = $this->dummyData->getUser();
        $cart1 = $this->dummyData->getCart();

        $this->cartRepository
            ->shouldReceive('findOneByUserId')
            ->with($user->getId())
            ->andReturn($cart1);

        $cart = $this->cartService->findByUser(
            $user->getId()
        );

        $this->assertEqualEntities($cart1, $cart);
    }

    public function testFindOneBySession()
    {
        $cart1 = $this->dummyData->getCart();
        $this->cartRepository
            ->shouldReceive('findOneBySession')
            ->with(self::SESSION_ID)
            ->andReturn($cart1);

        $cart = $this->cartService->findBySession(self::SESSION_ID);

        $this->assertEqualEntities($cart1, $cart);
    }

    public function testAddCouponByCode()
    {
        $cart = $this->getCartThatRepositoryWillFind();
        $this->cartRepositoryShouldUpdateOnce($cart);

        $coupon = $this->dummyData->getCoupon('20PCT');
        $this->couponRepository->shouldReceive('findOneByCode')
            ->with($coupon->getCode())
            ->andReturn($coupon)
            ->once();

        $couponIndex = $this->cartService->addCouponByCode($cart->getId(), $coupon->getCode());

        $this->assertEqualEntities($coupon, $cart->getCoupons()[$couponIndex]);
    }

    public function testGetCoupons()
    {
        $coupon = $this->dummyData->getCoupon();
        $cart = $this->getCartThatRepositoryWillFind();
        $cart->addCoupon($coupon);

        $coupons = $this->cartService->getCoupons($cart->getId());

        $this->assertEqualEntities($coupon, $coupons[0]);
    }

    public function testRemoveCart()
    {
        $cart = $this->getCartThatRepositoryWillFind();
        $this->cartRepository
            ->shouldReceive('delete')
            ->with($cart)
            ->once();

        $this->cartService->removeCart($cart->getId());
    }

    public function testRemoveCoupon()
    {
        $coupon = $this->dummyData->getCoupon();
        $cart = $this->getCartThatRepositoryWillFind();
        $couponIndex = $cart->addCoupon($coupon);
        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->removeCoupon($cart->getId(), $couponIndex);

        $this->assertCount(0, $cart->getCoupons());
    }

    public function testCreateWithSession()
    {
        $this->cartRepositoryShouldCreateOnce();

        $userId = null;
        $cart = $this->cartService->create(self::IP4, $userId, self::SESSION_ID);

        $this->assertSame($userId, $cart->getUser());
        $this->assertSame(self::SESSION_ID, $cart->getSessionId());
        $this->assertSame(self::IP4, $cart->getIp4());
        $this->assertTrue($cart->getUpdated()->getTimestamp() > 0);
    }

    public function testCreateWithUser()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneById')
            ->with($user->getId())
            ->andReturn($user)
            ->once();

        $this->cartRepositoryShouldCreateOnce();

        $sessionId = null;
        $cart = $this->cartService->create(self::IP4, $user->getId(), $sessionId);

        $this->assertSame($user, $cart->getUser());
        $this->assertSame($sessionId, $cart->getSessionId());
        $this->assertSame(self::IP4, $cart->getIp4());
    }

    public function testCreateWithNone()
    {
        $this->setExpectedException(
            InvalidArgumentException::class,
            'User or session id required'
        );

        $this->cartService->create(self::IP4);
    }

    public function testAddItem()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('findOneById')
            ->with($product->getId())
            ->andReturn($product)
            ->once();

        $cart = $this->getCartThatRepositoryWillFind();
        $this->cartRepositoryShouldUpdateOnce($cart);

        $cartItemIndex = $this->cartService->addItem($cart->getId(), $product->getid());

        $this->assertSame(0, $cartItemIndex);
        $this->assertTrue($cart->getCartItem($cartItemIndex) instanceof CartItem);
        $this->assertSame(null, $cart->getShipmentRate());
    }

    public function testAddItemOptionProducts()
    {
        $optionProductIds = [101];

        $product = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('findOneById')
            ->with($product->getId())
            ->andReturn($product)
            ->once();

        $cart = $this->getCartThatRepositoryWillFind();
        $this->cartRepositoryShouldUpdateOnce($cart);
        $cartItemIndex = $this->cartService->addItem($cart->getId(), $product->getId());
        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->addItemOptionProducts($cart->getId(), $cartItemIndex, $optionProductIds);

        // TODO: Test CartService::addItemOptionProducts()
    }

    public function testAddItemOptionValues()
    {
        $optionValueIds = [201];

        $product = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('findOneById')
            ->with($product->getId())
            ->andReturn($product)
            ->once();

        $cart = $this->getCartThatRepositoryWillFind();
        $this->cartRepositoryShouldUpdateOnce($cart);
        $cartItemIndex = $this->cartService->addItem($cart->getId(), $product->getId());
        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->addItemOptionValues($cart->getId(), $cartItemIndex, $optionValueIds);

        // TODO: Test CartService::addItemOptionValues()
    }

    public function testAddItemTextOptionValues()
    {
        $textOption = new TextOption;
        $this->textOptionRepository->setReturnValue($textOption);

        $textOptionValues = [$textOption->getId()->getHex() => 'Happy Birthday'];

        $product = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('findOneById')
            ->with($product->getId())
            ->andReturn($product)
            ->once();

        $cart = $this->getCartThatRepositoryWillFind();
        $this->cartRepositoryShouldUpdateOnce($cart);
        $cartItemIndex = $this->cartService->addItem($cart->getId(), $product->getId());
        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->addItemTextOptionValues($cart->getId(), $cartItemIndex, $textOptionValues);

        // TODO: Test CartService::addItemTextOptionValues()
    }

    public function testCopyCartItems()
    {
        $cartItem = $this->dummyData->getCartItem();
        $fromCart = $this->dummyData->getCart([$cartItem]);
        $toCart = $this->dummyData->getCart();

        $this->getCartThatRepositoryWillFind($fromCart);
        $this->getCartThatRepositoryWillFind($toCart);
        $this->cartRepositoryShouldUpdateOnce($toCart);

        $this->cartService->copyCartItems($fromCart->getId(), $toCart->getId());

        $this->assertEquals($cartItem->getId(), $toCart->getCartItem(0)->getId());
    }

    public function testUpdateQuantity()
    {
        $cartItem = $this->dummyData->getCartItem();
        $cart = $this->dummyData->getCart([$cartItem]);
        $cart->setShipmentRate($this->dummyData->getShipmentRate());
        $this->getCartThatRepositoryWillFind($cart);
        $this->cartRepositoryShouldUpdateOnce($cart);

        $cartItemIndex = 0;
        $quantity = 2;
        $this->cartService->updateQuantity($cart->getId(), $cartItemIndex, $quantity);

        $this->assertSame($quantity, $cart->getCartItem($cartItemIndex)->getQuantity());
        $this->assertSame(null, $cart->getShipmentRate());
    }

    public function testDeleteItem()
    {
        $cartItem = $this->dummyData->getCartItem();
        $cart = $this->dummyData->getCart([$cartItem]);
        $cart->setShipmentRate($this->dummyData->getShipmentRate());
        $this->getCartThatRepositoryWillFind($cart);
        $this->cartRepositoryShouldUpdateOnce($cart);

        $cartItemIndex = 0;
        $this->cartService->deleteItem($cart->getId(), $cartItemIndex);

        $this->assertCount(0, $cart->getCartItems());
        $this->assertSame(null, $cart->getShipmentRate());
    }

    public function testFindOneById()
    {
        $cart = $this->getCartThatRepositoryWillFind();
        $this->assertSame($cart, $this->cartService->findOneById($cart->getId()));
    }

    public function testSetTaxRate()
    {
        $cart = $this->getCartThatRepositoryWillFind();
        $taxRate = $this->dummyData->getTaxRate();
        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->setTaxRate($cart->getId(), $taxRate);

        $this->assertSame($taxRate, $cart->getTaxRate());
    }

    public function testSetUserById()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->shouldReceive('findOneById')
            ->with($user->getId())
            ->andReturn($user)
            ->once();

        $cart = $this->getCartThatRepositoryWillFind();
        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->setUserById($cart->getId(), $user->getId());

        $this->assertSame($user, $cart->getUser());
    }

    public function testSetSessionId()
    {
        $cart = $this->getCartThatRepositoryWillFind();
        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->setSessionId($cart->getId(), self::SESSION_ID);

        $this->assertSame(self::SESSION_ID, $cart->getSessionId());
    }

    public function testSetExternalShipmentRate()
    {
        $cart = $this->getCartThatRepositoryWillFind();
        $this->cartRepositoryShouldUpdateOnce($cart);

        $zip5 = self::ZIP5;
        $shipmentRateExternalId = self::SHIPMENT_RATE_EXTERNAL_ID;

        $orderAddress = $this->dummyData->getOrderAddress();
        $orderAddress->setZip5($zip5);
        $orderAddressDTO = $orderAddress->getDTOBuilder()->build();

        $this->cartService->setExternalShipmentRate($cart->getId(), $shipmentRateExternalId, $orderAddressDTO);

        $this->assertSame($shipmentRateExternalId, $cart->getShipmentRate()->getShipmentExternalId());
        $this->assertSame($zip5, $cart->getShippingAddress()->getZip5());
    }

    public function testSetShipmentRate()
    {
        $shipmentRate = $this->dummyData->getShipmentRate();
        $cart = $this->getCartThatRepositoryWillFind();
        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->setShipmentRate($cart->getId(), $shipmentRate);

        $this->assertSame($shipmentRate, $cart->getShipmentRate());
    }

    /**
     * @param Cart $cart
     * @return Cart
     */
    private function getCartThatRepositoryWillFind(Cart $cart = null)
    {
        if ($cart === null) {
            $cart = $this->dummyData->getCart();
        }

        $this->cartRepository
            ->shouldReceive('findOneByUuid')
            ->with($cart->getId())
            ->andReturn($cart);

        return $cart;
    }

    private function cartRepositoryShouldUpdateOnce(Cart $cart)
    {
        $this->cartRepository
            ->shouldReceive('update')
            ->with($cart)
            ->once();
    }

    private function cartRepositoryShouldCreateOnce()
    {
        $this->cartRepository
            ->shouldReceive('create')
            ->once();
    }
}
