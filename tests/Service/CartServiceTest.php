<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\Exception\InvalidCartActionException;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCartRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeInventoryLocationRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeInventoryTransactionRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionProductRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOptionValueRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTaxRateRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTextOptionRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeCouponRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeUserRepository;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;
use Ramsey\Uuid\Uuid;

class CartServiceTest extends ServiceTestCase
{
    /** @var CartService */
    protected $cartService;

    /** @var CartCalculator */
    protected $cartCalculator;

    /** @var CartRepositoryInterface | \Mockery\Mock */
    protected $cartRepository;

    /** @var FakeCouponRepository */
    protected $couponRepository;

    /** @var FakeEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var FakeOptionProductRepository */
    protected $optionProductRepository;

    /** @var FakeOptionValueRepository */
    protected $optionValueRepository;

    /** @var FakeOrderRepository */
    protected $orderRepository;

    /** @var FakeProductRepository */
    protected $productRepository;

    /** @var FakeShipmentGateway */
    protected $fakeShipmentGateway;

    /** @var FakeTaxRateRepository */
    protected $taxRateRepository;

    /** @var FakeTextOptionRepository */
    protected $textOptionRepository;

    /** @var FakeUserRepository */
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
        $this->couponRepository = new FakeCouponRepository;
        $this->fakeEventDispatcher = new FakeEventDispatcher;
        $this->productRepository = new FakeProductRepository;
        $this->optionProductRepository = new FakeOptionProductRepository;
        $this->optionValueRepository = new FakeOptionValueRepository;
        $this->orderRepository = new FakeOrderRepository;
        $this->fakeShipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);
        $this->taxRateRepository = new FakeTaxRateRepository;
        $this->textOptionRepository = new FakeTextOptionRepository;
        $this->userRepository = new FakeUserRepository;
        $this->inventoryLocationRepository = new FakeInventoryLocationRepository;
        $this->inventoryTransactionRepository = new FakeInventoryTransactionRepository;

        $customerHoldInventoryLocation = $this->dummyData->getInventoryLocation();
        $customerHoldInventoryLocation->setName('Hold For Customer Order');
        $customerHoldInventoryLocation->setCode('CUSTOMER-HOLD');

        $this->inventoryLocationRepository->create($customerHoldInventoryLocation);

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
        $userId = 1;
        $this->cartRepository
            ->shouldReceive('findOneByUser')
            ->with($userId)
            ->andReturn($this->dummyData->getCart());

        $cart = $this->cartService->findByUser($userId);

        $this->assertTrue($cart instanceof Cart);
    }

    public function testFindOneBySession()
    {
        $sessionId = '6is7ujb3crb5ja85gf91g9en62';

        $this->cartRepository
            ->shouldReceive('findOneBySession')
            ->with($sessionId)
            ->andReturn($this->dummyData->getCart());

        $cart = $this->cartService->findBySession($sessionId);

        $this->assertTrue($cart instanceof Cart);
    }

    public function testAddCouponByCode()
    {
        $coupon = $this->dummyData->getCoupon();
        $coupon->setCode('20PCT');
        $this->couponRepository->create($coupon);

        $cart = $this->getCartThatRepositoryWillFind();

        $this->cartRepository
            ->shouldReceive('update')
            ->once();

        $couponIndex = $this->cartService->addCouponByCode($cart->getId(), $coupon->getCode());

        $this->assertSame(0, $couponIndex);
    }

    public function testAddCouponByCodeMissingThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Coupon not found'
        );

        $this->cartService->addCouponByCode(Uuid::uuid4(), 'code');
    }

    public function testGetCoupons()
    {
        $coupon = $this->dummyData->getCoupon();
        $cart = $this->dummyData->getCart();
        $cart->addCoupon($coupon);

        $this->cartRepository
            ->shouldReceive('findOneByUuid')
            ->with($cart->getId())
            ->andReturn($cart);

        $coupons = $this->cartService->getCoupons($cart->getId());

        $this->assertSame($coupon, $coupons[0]);
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
        $cart = $this->dummyData->getCart();
        $couponIndex = $cart->addCoupon($coupon);

        $this->cartRepository
            ->shouldReceive('findOneByUuid')
            ->with($cart->getId())
            ->andReturn($cart);

        $this->cartRepository
            ->shouldReceive('update')
            ->with($cart)
            ->once();

        $this->cartService->removeCoupon($cart->getId(), $couponIndex);

        $this->assertCount(0, $cart->getCoupons());
    }

    public function testCreateWithSession()
    {
        $userId = null;
        $sessionId = '6is7ujb3crb5ja85gf91g9en62';
        $ip4 = '10.0.0.1';

        $this->cartRepository
            ->shouldReceive('create')
            ->once();

        $cart = $this->cartService->create($userId, $sessionId, $ip4);

        $this->assertSame($userId, $cart->getUser());
        $this->assertSame($sessionId, $cart->getSessionId());
        $this->assertSame($ip4, $cart->getIp4());
    }

    public function testCreateWithUser()
    {
        $sessionId = null;
        $ip4 = '10.0.0.1';

        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $this->cartRepository
            ->shouldReceive('create')
            ->once();

        $cart = $this->cartService->create($user->getId(), $sessionId, $ip4);

        $this->assertSame($user, $cart->getUser());
        $this->assertSame($sessionId, $cart->getSessionId());
        $this->assertSame($ip4, $cart->getIp4());
    }

    public function testCreateFailsWithMissingUser()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'User not found'
        );

        $this->cartService->create(999, null, '10.0.0.1');
    }

    public function testCreateWithNone()
    {
        $this->setExpectedException(
            InvalidArgumentException::class,
            'User or session id required'
        );

        $this->cartService->create(null, null, '10.0.0.1');
    }

    public function testAddItem()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->create($product);

        $cart = $this->getCartThatRepositoryWillFind();

        $this->cartRepository
            ->shouldReceive('update')
            ->once();

        $cartItemIndex = $this->cartService->addItem($cart->getId(), $product->getid());

        $this->assertSame(0, $cartItemIndex);
        $this->assertTrue($cart->getCartItem($cartItemIndex) instanceof CartItem);
        $this->assertSame(null, $cart->getShipmentRate());
    }

    public function testAddItemWithMissingProductThrowsException()
    {
        $productId = 2001;

        $cart = $this->dummyData->getCart();

        $this->setExpectedException(
            EntityNotFoundException::class,
            'Product not found'
        );

        $this->cartService->addItem($cart->getId(), $productId);
    }

    public function testAddItemOptionProducts()
    {
        $optionProductIds = [101];

        $product = $this->dummyData->getProduct();
        $this->productRepository->create($product);

        $cart = $this->getCartThatRepositoryWillFind();

        $this->cartRepository
            ->shouldReceive('update')
            ->once();

        $cartItemIndex = $this->cartService->addItem($cart->getId(), $product->getId());

        $this->cartRepository
            ->shouldReceive('update')
            ->once();

        $this->cartService->addItemOptionProducts($cart->getId(), $cartItemIndex, $optionProductIds);

        // TODO: Test CartService::addItemOptionProducts()
    }

    public function testAddItemOptionValues()
    {
        $optionValueIds = [201];

        $product = $this->dummyData->getProduct();
        $this->productRepository->create($product);

        $cart = $this->getCartThatRepositoryWillFind();

        $this->cartRepository
            ->shouldReceive('update')
            ->once();

        $cartItemIndex = $this->cartService->addItem($cart->getId(), $product->getId());

        $this->cartRepository
            ->shouldReceive('update')
            ->once();

        $this->cartService->addItemOptionValues($cart->getId(), $cartItemIndex, $optionValueIds);

        // TODO: Test CartService::addItemOptionValues()
    }

    public function testAddItemTextOptionValues()
    {
        $textOption = new TextOption;
        $textOption->setId(301);
        $this->textOptionRepository->setReturnValue($textOption);

        $textOptionValues = [$textOption->getId() => 'Happy Birthday'];

        $product = $this->dummyData->getProduct();
        $this->productRepository->create($product);

        $cart = $this->getCartThatRepositoryWillFind();

        $this->cartRepository
            ->shouldReceive('update')
            ->once();

        $cartItemIndex = $this->cartService->addItem($cart->getId(), $product->getId());

        $this->cartRepository
            ->shouldReceive('update')
            ->once();

        $this->cartService->addItemTextOptionValues($cart->getId(), $cartItemIndex, $textOptionValues);

        // TODO: Test CartService::addItemTextOptionValues()
    }

    public function testCopyCartItems()
    {
        $cartItem = $this->dummyData->getCartItem();
        $fromCart = $this->dummyData->getCart([$cartItem]);
        $toCart = $this->dummyData->getCart();

        $this->cartRepository
            ->shouldReceive('findOneByUuid')
            ->with($fromCart->getId())
            ->andReturn($fromCart);

        $this->cartRepository
            ->shouldReceive('findOneByUuid')
            ->with($toCart->getId())
            ->andReturn($toCart);

        $this->cartRepository
            ->shouldReceive('update')
            ->with($toCart);

        $this->cartService->copyCartItems($fromCart->getId(), $toCart->getId());

        $this->assertEquals($cartItem->getId(), $toCart->getCartItem(0)->getId());
    }

    public function testUpdateQuantity()
    {
        $cartItem = $this->dummyData->getCartItem();
        $cart = $this->dummyData->getCart([$cartItem]);
        $cart->setShipmentRate($this->dummyData->getShipmentRate());

        $this->cartRepository
            ->shouldReceive('findOneByUuid')
            ->with($cart->getId())
            ->andReturn($cart);

        $this->cartRepository
            ->shouldReceive('update')
            ->with($cart)
            ->once();

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

        $this->cartRepository
            ->shouldReceive('findOneByUuid')
            ->with($cart->getId())
            ->andReturn($cart);

        $this->cartRepository
            ->shouldReceive('update')
            ->with($cart)
            ->once();

        $cartItemIndex = 0;
        $this->cartService->deleteItem($cart->getId(), $cartItemIndex);

        $this->assertCount(0, $cart->getCartItems());
        $this->assertSame(null, $cart->getShipmentRate());
    }

    public function testFindOneById()
    {
        $cart = $this->getCartThatRepositoryWillFind();

        $cart = $this->cartService->findOneById($cart->getId());
    }

    public function testSetTaxRate()
    {
        $cart = $this->getCartThatRepositoryWillFind();

        $taxRate = $this->dummyData->getTaxRate();

        $this->cartRepository
            ->shouldReceive('update')
            ->with($cart)
            ->once();

        $this->cartService->setTaxRate($cart->getId(), $taxRate);
        $this->assertSame($taxRate, $cart->getTaxRate());
    }

    public function testSetUserById()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $cart = $this->getCartThatRepositoryWillFind();

        $this->cartRepository
            ->shouldReceive('update')
            ->with($cart)
            ->once();

        $this->cartService->setUserById($cart->getId(), $user->getId());

        $this->assertSame($user, $cart->getUser());
    }

    public function testSetSessionId()
    {
        $sessionId = '6is7ujb3crb5ja85gf91g9en62';

        $cart = $this->getCartThatRepositoryWillFind();

        $this->cartRepository
            ->shouldReceive('update')
            ->with($cart)
            ->once();

        $this->cartService->setSessionId($cart->getId(), $sessionId);

        $this->assertSame($sessionId, $cart->getSessionId());
    }

    public function testSetExternalShipmentRate()
    {
        $cart = $this->getCartThatRepositoryWillFind();

        $this->cartRepository
            ->shouldReceive('update')
            ->with($cart)
            ->once();

        $zip5 = '76667';
        $shipmentRateExternalId = 'shp_xxxxxxxx';

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

        $this->cartRepository
            ->shouldReceive('update')
            ->with($cart)
            ->once();


        $this->cartService->setShipmentRate($cart->getId(), $shipmentRate);

        $this->assertSame($shipmentRate, $cart->getShipmentRate());
    }

    /**
     * @return Cart
     */
    private function getCartThatRepositoryWillFind()
    {
        $cart = $this->dummyData->getCart();
        $this->cartRepository
            ->shouldReceive('findOneByUuid')
            ->with($cart->getId())
            ->andReturn($cart);

        return $cart;
    }
}
