<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
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
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;
use inklabs\kommerce\Lib\Event\LoggingEventDispatcher;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class CartServiceTest extends ServiceTestCase
{
    /** @var CartService */
    protected $cartService;

    /** @var CartCalculator */
    protected $cartCalculator;

    /** @var CartRepositoryInterface */
    protected $cartRepository;

    /** @var CouponRepositoryInterface */
    protected $couponRepository;

    /** @var LoggingEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var OptionProductRepositoryInterface */
    protected $optionProductRepository;

    /** @var OptionValueRepositoryInterface */
    protected $optionValueRepository;

    /** @var OrderRepositoryInterface */
    protected $orderRepository;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var FakeShipmentGateway */
    protected $fakeShipmentGateway;

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    /** @var TextOptionRepositoryInterface*/
    protected $textOptionRepository;

    /** @var UserRepositoryInterface */
    protected $userRepository;

    /** @var InventoryLocationRepositoryInterface */
    protected $inventoryLocationRepository;

    /** @var InventoryTransactionRepositoryInterface */
    protected $inventoryTransactionRepository;

    /** @var InventoryServiceInterface */
    protected $inventoryService;

    protected $metaDataClassNames = [
        Cart::class,
        CartItem::class,
        CartItemOptionProduct::class,
        CartItemOptionValue::class,
        CartItemTextOptionValue::class,
        Image::class,
        Option::class,
        OptionProduct::class,
        OptionValue::class,
        Product::class,
        ProductQuantityDiscount::class,
        Tag::class,
        TaxRate::class,
        TextOption::class,
        User::class,
    ];

    public function setUp()
    {
        parent::setUp();

        $this->cartCalculator = new CartCalculator(new Pricing);
        $this->cartRepository = $this->getRepositoryFactory()->getCartRepository();
        $this->couponRepository = $this->getRepositoryFactory()->getCouponRepository();
        $this->fakeEventDispatcher = new LoggingEventDispatcher(new EventDispatcher());
        $this->productRepository = $this->getRepositoryFactory()->getProductRepository();
        $this->optionProductRepository = $this->getRepositoryFactory()->getOptionProductRepository();
        $this->optionValueRepository = $this->getRepositoryFactory()->getOptionValueRepository();
        $this->orderRepository = $this->getRepositoryFactory()->getOrderRepository();
        $this->fakeShipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);
        $this->taxRateRepository = $this->getRepositoryFactory()->getTaxRateRepository();
        $this->textOptionRepository = $this->getRepositoryFactory()->getTextOptionRepository();
        $this->userRepository = $this->getRepositoryFactory()->getUserRepository();
        $this->inventoryLocationRepository = $this->getRepositoryFactory()->getInventoryLocationRepository();
        $this->inventoryTransactionRepository = $this->getRepositoryFactory()->getInventoryTransactionRepository();

        $this->inventoryService = new InventoryService(
            $this->inventoryLocationRepository,
            $this->inventoryTransactionRepository
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

    public function testCreateWithSession()
    {
        // Given
        $userId = null;
        $cartId = Uuid::uuid4();

        // When
        $cart = $this->cartService->create($cartId, self::IP4, $userId, self::SESSION_ID);

        // Then
        $this->entityManager->clear();
        $actualCart = $this->getRepositoryFactory()->getCartRepository()->findOneById($cartId);
        $this->assertEntitiesEqual($cart, $actualCart);
        $this->assertSame($userId, $actualCart->getUser());
        $this->assertSame(self::SESSION_ID, $actualCart->getSessionId());
        $this->assertSame(self::IP4, $actualCart->getIp4());
        $this->assertTrue($actualCart->getUpdated()->getTimestamp() > 0);
    }

    public function testCreateWithUser()
    {
        // Given
        $user = $this->dummyData->getUser();
        $this->persistEntityAndFlushClear($user);

        $sessionId = null;
        $cartId = Uuid::uuid4();

        // When
        $cart = $this->cartService->create($cartId, self::IP4, $user->getId(), $sessionId);

        // Then
        $this->entityManager->clear();
        $actualCart = $this->getRepositoryFactory()->getCartRepository()->findOneById($cartId);
        $this->assertEntitiesEqual($cart, $actualCart);
        $this->assertEntitiesEqual($user, $actualCart->getUser());
        $this->assertSame($sessionId, $actualCart->getSessionId());
        $this->assertSame(self::IP4, $actualCart->getIp4());
    }

    public function testCreateWithNone()
    {
        // Given

        // Then
        $this->setExpectedException(
            InvalidArgumentException::class,
            'User or session id required'
        );

        // When
        $this->cartService->create(Uuid::uuid4(), self::IP4);
    }

    public function testAddItem()
    {
        // Given
        $product = $this->dummyData->getProduct();
        $cart = $cart = $this->dummyData->getCart();
        $this->persistEntityAndFlushClear([
            $product,
            $cart,
        ]);
        $cartItemId = Uuid::uuid4();

        // When
        $cartItem = $this->cartService->addItem($cartItemId, $cart->getId(), $product->getid());

        // Then
        $this->entityManager->clear();
        $actualCart = $this->getRepositoryFactory()->getCartRepository()->findOneById($cart->getId());
        $actualCartItem = $actualCart->getCartItems()[0];
        $this->assertEntitiesEqual($cartItem, $actualCartItem);
        $this->assertEquals(1, $actualCartItem->getQuantity());
        $this->assertSame(null, $actualCart->getShipmentRate()->getService());
    }

    public function testAddItemOptionProducts()
    {
        // Given
        $option = $this->dummyData->getOption();
        $product1 = $this->dummyData->getProduct();
        $optionProduct = $this->dummyData->getOptionProduct($option, $product1);
        $optionProductIds = [$optionProduct->getId()];
        $product2 = $this->dummyData->getProduct();
        $cart = $this->dummyData->getCart();
        $cartItem = $this->dummyData->getCartItem($cart, $product2);
        $this->persistEntityAndFlushClear([
            $option,
            $product1,
            $product2,
            $optionProduct,
            $cart,
            $cartItem,
        ]);

        // When
        $this->cartService->addItemOptionProducts($cartItem->getId(), $optionProductIds);

        // Then
        $this->entityManager->clear();
        $actualCart = $this->getRepositoryFactory()->getCartRepository()->findOneById($cart->getId());
        $actualCartItem = $actualCart->getCartItems()[0];
        $actualOptionProduct = $actualCartItem->getCartItemOptionProducts()[0]->getOptionProduct();

        $this->assertEntitiesEqual($optionProduct, $actualOptionProduct);
    }

    public function testAddItemOptionValues()
    {
        // Given
        $option = $this->dummyData->getOption();
        $optionValue = $this->dummyData->getOptionValue($option);
        $optionValueIds = [$optionValue->getId()];

        $cart = $this->dummyData->getCart();
        $product = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem($cart, $product);

        $this->persistEntityAndFlushClear([
            $option,
            $optionValue,
            $product,
            $cart,
            $cartItem,
        ]);

        // When
        $this->cartService->addItemOptionValues($cartItem->getId(), $optionValueIds);

        // Then
        $this->entityManager->clear();
        $actualCart = $this->getRepositoryFactory()->getCartRepository()->findOneById($cart->getId());
        $actualCartItem = $actualCart->getCartItems()[0];
        $actualOptionValue = $actualCartItem->getCartItemOptionValues()[0]->getOptionValue();
        $this->assertEntitiesEqual($optionValue, $actualOptionValue);
    }

    public function testAddItemTextOptionValues()
    {
        // Given
        $cart = $this->dummyData->getCart();
        $product = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem($cart, $product);
        $textOption = $this->dummyData->getTextOption();
        $textOptionValue = 'Happy Birthday';
        $textOptionValueDTO = new TextOptionValueDTO(
            $textOption->getId()->getHex(),
            $textOptionValue
        );
        $this->persistEntityAndFlushClear([
            $product,
            $cart,
            $cartItem,
            $textOption,
        ]);

        // When
        $this->cartService->addItemTextOptionValues($cartItem->getId(), [$textOptionValueDTO]);

        // Then
        $this->entityManager->clear();
        $actualCart = $this->getRepositoryFactory()->getCartRepository()->findOneById($cart->getId());
        $cartItemTextOptionValue = $actualCart->getCartItems()[0]->getCartItemTextOptionValues()[0];

        $this->assertSame($textOptionValue, $cartItemTextOptionValue->getTextOptionValue());
        $this->assertEntitiesEqual($textOption, $cartItemTextOptionValue->getTextOption());
    }

    public function testCopyCartItems()
    {
        // Given
        $fromCart = $this->dummyData->getCart();
        $toCart = $this->dummyData->getCart();
        $cartItem1 = $this->dummyData->getCartItemFull($fromCart);
        $this->persistEntityAndFlushClear([
            $fromCart,
            $toCart,
            $cartItem1,
            $cartItem1->getProduct(),
            $cartItem1->getProduct()->getTags()[0],
            $cartItem1->getProduct()->getTags()[0]->getImages()[0],
            $cartItem1->getProduct()->getProductQuantityDiscounts()[0],
            $cartItem1->getCartItemOptionProducts()[0]->getOptionProduct(),
            $cartItem1->getCartItemOptionProducts()[0]->getOptionProduct()->getOption(),
            $cartItem1->getCartItemOptionProducts()[0]->getOptionProduct()->getProduct(),
            $cartItem1->getCartItemOptionValues()[0]->getOptionValue(),
            $cartItem1->getCartItemOptionValues()[0]->getOptionValue()->getOption(),
            $cartItem1->getCartItemTextOptionValues()[0]->getTextOption(),
        ]);

        // When
        $this->cartService->copyCartItems($fromCart->getId(), $toCart->getId());

        // Then
        $this->entityManager->clear();
        $actualToCart = $this->getRepositoryFactory()->getCartRepository()->findOneById($toCart->getId());
        $actualCartItem = $actualToCart->getCartItems()[0];
        $this->assertEntitiesEqual($cartItem1->getProduct(), $actualCartItem->getProduct());
        $this->assertEntitiesNotEqual($cartItem1, $actualCartItem);
        $this->assertEntitiesNotEqual(
            $cartItem1->getCartItemOptionValues()[0],
            $actualCartItem->getCartItemOptionValues()[0]
        );
        $this->assertEntitiesNotEqual(
            $cartItem1->getCartItemOptionProducts()[0],
            $actualCartItem->getCartItemOptionProducts()[0]
        );
        $this->assertEntitiesNotEqual(
            $cartItem1->getCartItemTextOptionValues()[0],
            $actualCartItem->getCartItemTextOptionValues()[0]
        );
        $this->assertEquals($cartItem1->getQuantity(), $actualCartItem->getQuantity());
    }

    public function testDeleteItem()
    {
        // Given
        $cart = $this->dummyData->getCart();
        $cart->setShipmentRate($this->dummyData->getShipmentRate());
        $product = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem($cart, $product);
        $this->persistEntityAndFlushClear([
            $cart,
            $product,
        ]);

        // When
        $this->cartService->deleteItem($cartItem->getId());

        // Then
        $this->entityManager->clear();
        $actualCart = $this->getRepositoryFactory()->getCartRepository()->findOneById($cart->getId());
        $this->assertCount(0, $actualCart->getCartItems());
        $this->assertSame(null, $actualCart->getShipmentRate()->getCarrier());
    }

    public function testSetExternalShipmentRate()
    {
        // Given
        $cart = $this->dummyData->getCart();
        $orderAddressDTO = new OrderAddressDTO;
        $orderAddressDTO->zip5 = self::ZIP5;
        $taxRate = $this->dummyData->getTaxRate();
        $this->persistEntityAndFlushClear([
            $cart,
            $taxRate,
        ]);

        // When
        $this->cartService->setExternalShipmentRate(
            $cart->getId(),
            self::SHIPMENT_RATE_EXTERNAL_ID,
            $orderAddressDTO
        );

        // Then
        $this->entityManager->clear();
        $actualCart = $this->getRepositoryFactory()->getCartRepository()->findOneById($cart->getId());
        $this->assertSame(self::SHIPMENT_RATE_EXTERNAL_ID, $actualCart->getShipmentRate()->getShipmentExternalId());
        $this->assertSame(self::ZIP5, $actualCart->getShippingAddress()->getZip5());
    }
}
