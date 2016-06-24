<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\InputDTO\TextOptionValueDTO;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
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

    /** @var OptionProductRepositoryInterface | \Mockery\Mock */
    protected $optionProductRepository;

    /** @var OptionValueRepositoryInterface | \Mockery\Mock */
    protected $optionValueRepository;

    /** @var OrderRepositoryInterface | \Mockery\Mock */
    protected $orderRepository;

    /** @var ProductRepositoryInterface | \Mockery\Mock */
    protected $productRepository;

    /** @var FakeShipmentGateway */
    protected $fakeShipmentGateway;

    /** @var TaxRateRepositoryInterface | \Mockery\Mock */
    protected $taxRateRepository;

    /** @var TextOptionRepositoryInterface | \Mockery\Mock*/
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
        $this->optionProductRepository = $this->mockRepository->getOptionProductRepository();
        $this->optionValueRepository = $this->mockRepository->getOptionValueRepository();
        $this->orderRepository = $this->mockRepository->getOrderRepository();
        $this->fakeShipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);
        $this->taxRateRepository = $this->mockRepository->getTaxRateRepository();
        $this->textOptionRepository = $this->mockRepository->getTextOptionRepository();
        $this->userRepository = $this->mockRepository->getUserRepository();
        $this->inventoryLocationRepository = $this->mockRepository->getInventoryLocationRepository();
        $this->inventoryTransactionRepository = $this->mockRepository->getInventoryTransactionRepository();

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

        $this->cartService->addCouponByCode($cart->getId(), $coupon->getCode());

        $this->assertEqualEntities($coupon, $cart->getCoupons()[0]);
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
        $cart->addCoupon($coupon);
        $this->cartRepositoryShouldUpdateOnce($cart);
        $this->couponRepository->shouldReceive('findOneById')
            ->with($coupon->getId())
            ->andReturn($coupon);

        $this->cartService->removeCoupon($cart->getId(), $coupon->getId());

        $this->assertCount(0, $cart->getCoupons());
    }

    public function testCreateWithSession()
    {
        $this->cartRepositoryShouldCreateOnce();

        $userId = null;
        $cart = $this->cartService->create(Uuid::uuid4(), self::IP4, $userId, self::SESSION_ID);

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
        $cart = $this->cartService->create(Uuid::uuid4(), self::IP4, $user->getId(), $sessionId);

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

        $this->cartService->create(Uuid::uuid4(), self::IP4);
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

        $cartItemId = Uuid::uuid4();
        $cartItem = $this->cartService->addItem($cartItemId, $cart->getId(), $product->getid());

        $this->assertEqualEntities($cartItem, $cart->getCartItems()[0]);
        $this->assertSame(null, $cart->getShipmentRate());
    }

    public function testAddItemOptionProducts()
    {
        $optionProduct = $this->dummyData->getOptionProduct();
        $optionProductIds = [$optionProduct->getId()];

        $product = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem($product);
        $cart = $this->dummyData->getCart([$cartItem]);

        $this->optionProductRepository->shouldReceive('getAllOptionProductsByIds')
            ->with($optionProductIds)
            ->andReturn([$optionProduct])
            ->once();

        $this->cartRepository->shouldReceive('getItemById')
            ->with($cartItem->getId())
            ->andReturn($cartItem)
            ->once();

        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->addItemOptionProducts($cartItem->getId(), $optionProductIds);

        $this->assertEqualEntities(
            $optionProduct,
            $cart->getCartItems()[0]
                ->getCartItemOptionProducts()[0]
                ->getOptionProduct()
        );
    }

    public function testAddItemOptionValues()
    {
        $optionValue = $this->dummyData->getOptionValue();
        $optionValueIds = [$optionValue->getId()];

        $cartItem = $this->dummyData->getCartItem();
        $cart = $this->dummyData->getCart([$cartItem]);

        $this->optionValueRepository->shouldReceive('getAllOptionValuesByIds')
            ->with($optionValueIds)
            ->andReturn([$optionValue])
            ->once();

        $this->cartRepository->shouldReceive('getItemById')
            ->with($cartItem->getId())
            ->andReturn($cartItem)
            ->once();

        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->addItemOptionValues($cartItem->getId(), $optionValueIds);

        $this->assertEqualEntities(
            $optionValue,
            $cart->getCartItems()[0]
                ->getCartItemOptionValues()[0]
                ->getOptionValue()
        );
    }

    public function testAddItemTextOptionValues()
    {
        $cartItem = $this->dummyData->getCartItem();
        $cart = $this->dummyData->getCart([$cartItem]);

        $textOption = $this->dummyData->getTextOption();
        $this->textOptionRepository->shouldReceive('getAllTextOptionsByIds')
            ->andReturn([$textOption])
            ->once();

        $textOptionValue = 'Happy Birthday';
        $textOptionValueDTO = new TextOptionValueDTO(
            $textOption->getId()->getHex(),
            $textOptionValue
        );

        $this->cartRepository->shouldReceive('getItemById')
            ->with($cartItem->getId())
            ->andReturn($cartItem)
            ->once();

        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->addItemTextOptionValues($cartItem->getId(), [$textOptionValueDTO]);

        $cartItemTextOptionValue = $cart->getCartItems()[0]
            ->getCartItemTextOptionValues()[0];

        $this->assertSame($textOptionValue, $cartItemTextOptionValue->getTextOptionValue());
        $this->assertEqualEntities(
            $textOption,
            $cartItemTextOptionValue
                ->getTextOption()
        );
    }

    public function testCopyCartItems()
    {
        $cartItem1 = $this->dummyData->getCartItem();
        $fromCart = $this->dummyData->getCart([$cartItem1]);
        $toCart = $this->dummyData->getCart();

        $this->getCartThatRepositoryWillFind($fromCart);
        $this->getCartThatRepositoryWillFind($toCart);
        $this->cartRepositoryShouldUpdateOnce($toCart);

        $this->cartService->copyCartItems($fromCart->getId(), $toCart->getId());

        $cartItem = $toCart->getCartItems()[0];
        $this->assertEqualEntities($cartItem1->getProduct(), $cartItem->getProduct());
        $this->assertEquals($cartItem1->getQuantity(), $cartItem->getQuantity());
    }

    public function testUpdateItemQuantity()
    {
        $cartItem = $this->dummyData->getCartItem();
        $cart = $this->dummyData->getCart([$cartItem]);
        $cart->setShipmentRate($this->dummyData->getShipmentRate());

        $this->cartRepository->shouldReceive('getItemById')
            ->with($cartItem->getId())
            ->andReturn($cartItem)
            ->once();

        $this->cartRepositoryShouldUpdateOnce($cart);

        $cartItem = $cart->getCartItems()[0];
        $quantity = 2;

        $this->cartService->updateItemQuantity($cartItem->getId(), $quantity);

        $this->assertSame($quantity, $cartItem->getQuantity());
        $this->assertSame(null, $cart->getShipmentRate());
    }

    public function testDeleteItem()
    {
        $cartItem = $this->dummyData->getCartItem();
        $cart = $this->dummyData->getCart([$cartItem]);
        $cart->setShipmentRate($this->dummyData->getShipmentRate());

        $this->cartRepository->shouldReceive('getItemById')
            ->with($cartItem->getId())
            ->andReturn($cartItem)
            ->once();

        $this->cartRepositoryShouldUpdateOnce($cart);

        $this->cartService->deleteItem($cartItem->getId());

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

        $orderAddressDTO = new OrderAddressDTO;
        $orderAddressDTO->zip5 = self::ZIP5;

        $taxRate = $this->dummyData->getTaxRate();
        $this->taxRateRepository->shouldReceive('findByZip5AndState')
            ->with(self::ZIP5, null)
            ->andReturn($taxRate)
            ->once();

        $this->cartService->setExternalShipmentRate(
            $cart->getId(),
            self::SHIPMENT_RATE_EXTERNAL_ID,
            $orderAddressDTO
        );

        $this->assertSame(self::SHIPMENT_RATE_EXTERNAL_ID, $cart->getShipmentRate()->getShipmentExternalId());
        $this->assertSame(self::ZIP5, $cart->getShippingAddress()->getZip5());
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
            ->shouldReceive('findOneById')
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
