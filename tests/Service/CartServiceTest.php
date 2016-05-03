<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Coupon;
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

class CartServiceTest extends ServiceTestCase
{
    /** @var CartService */
    protected $cartService;

    /** @var CartCalculator */
    protected $cartCalculator;

    /** @var FakeCartRepository */
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
        $this->cartRepository = new FakeCartRepository;
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
        $coupon = $this->dummyData->getCoupon();
        $coupon->setCode('20PCT');
        $this->couponRepository->create($coupon);
        $this->cartRepository->create(new Cart);

        $couponIndex = $this->cartService->addCouponByCode(1, $coupon->getCode());
        $this->assertSame(0, $couponIndex);
    }

    public function testAddCouponByCodeMissingThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Coupon not found'
        );

        $this->cartService->addCouponByCode(1, 'code');
    }

    public function testGetCoupons()
    {
        $coupon = $this->dummyData->getCoupon();
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
        $coupon = $this->dummyData->getCoupon();
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
        $cart = $this->cartService->create(null, '6is7ujb3crb5ja85gf91g9en62', '10.0.0.1');
        $this->assertTrue($cart instanceof Cart);
    }

    public function testCreateWithUser()
    {
        $user = $this->dummyData->getUser();
        $this->userRepository->create($user);

        $cart = $this->cartService->create(1, null, '10.0.0.1');
        $this->assertTrue($cart instanceof Cart);
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
        $product = new Product;
        $cart = new Cart;
        $cart->setShipmentRate(new ShipmentRate(new Money(295, 'USD')));
        $this->cartRepository->create($cart);
        $this->productRepository->create($product);
        $cartItemIndex = $this->cartService->addItem($product->getId(), 1);

        $cart = $this->cartService->findOneById(1);

        $this->assertSame(0, $cartItemIndex);
        $this->assertTrue($cart->getCartItem(0) instanceof CartItem);
        $this->assertSame(null, $cart->getShipmentRate());
    }

    public function testAddItemWithMissingProductThrowsException()
    {
        $cartId = 1;
        $productId = 2001;

        $this->setExpectedException(
            EntityNotFoundException::class,
            'Product not found'
        );

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

    public function testAddItemOptionProductsThrowsException()
    {
        $cartId = 1;
        $cartItemIndex = 1;
        $optionProductIds = [101];

        $this->cartRepository->create(new Cart);

        $this->setExpectedException(
            InvalidCartActionException::class,
            'CartItem not found'
        );

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
        $product = new Product;
        $cart = new Cart;
        $cart->setShipmentRate(new ShipmentRate(new Money(295, 'USD')));
        $this->cartRepository->create($cart);
        $this->productRepository->create($product);
        $cartItemIndex = $this->cartService->addItem($cart->getId(), $product->getId());

        $this->cartService->updateQuantity($cart->getId(), $cartItemIndex, 2);

        $cart = $this->cartService->findOneById($cart->getId());
        $this->assertSame(2, $cart->getCartItem(0)->getQuantity());
        $this->assertSame(null, $cart->getShipmentRate());
    }

    public function testDeleteItem()
    {
        $product = new Product;
        $cart = new Cart;
        $cart->setShipmentRate(new ShipmentRate(new Money(295, 'USD')));
        $this->cartRepository->create($cart);
        $this->productRepository->create($product);
        $cartItemIndex = $this->cartService->addItem($cart->getId(), $product->getId());

        $this->cartService->deleteItem($cart->getId(), $cartItemIndex);

        $cart = $this->cartService->findOneById($cart->getId());
        $this->assertSame(0, count($cart->getCartItems()));
        $this->assertSame(null, $cart->getShipmentRate());
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

    public function testSetTaxRate()
    {
        $this->cartRepository->create(new Cart);
        $this->cartService->setTaxRate(1, new TaxRate);
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

        $testCart = $this->cartService->findOneById($cart->getId());
        $this->assertSame($sessionId, $testCart->getSessionId());
    }

    public function testSetUserWithMissingUserThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'User not found'
        );

        $this->cartService->setUserById(1, 1);
    }

    public function testSetExternalShipmentRate()
    {
        $orderAddress = $this->dummyData->getOrderAddress();
        $orderAddress->setZip5('76667');
        $orderAddressDTO = $orderAddress->getDTOBuilder()->build();

        $cart = $this->dummyData->getCart();
        $this->cartRepository->create($cart);
        $cartId = $cart->getId();

        $this->cartService->setExternalShipmentRate($cartId, 'shp_xxxxxxxx', $orderAddressDTO);

        $cart = $this->cartRepository->findOneById($cartId);
        $this->assertSame('shp_xxxxxxxx', $cart->getShipmentRate()->getShipmentExternalId());
        $this->assertSame('76667', $cart->getShippingAddress()->getZip5());
    }

    public function testSetShipmentRate()
    {
        $shipmentRate = $this->dummyData->getShipmentRate(1000, 'USD');

        $cart = $this->dummyData->getCart();
        $this->cartRepository->create($cart);
        $cartId = $cart->getId();

        $this->cartService->setShipmentRate($cartId, $shipmentRate);

        $cart = $this->cartRepository->findOneById($cartId);
        $this->assertEquals(new Money(1000, 'USD'), $cart->getShipmentRate()->getRate());
    }
}
