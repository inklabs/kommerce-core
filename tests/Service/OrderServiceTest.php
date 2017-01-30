<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\Entity\CreditPayment;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Event\OrderCreatedFromCartEvent;
use inklabs\kommerce\Event\OrderShippedEvent;
use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\Lib\PaymentGateway\FakePaymentGateway;
use inklabs\kommerce\Lib\PaymentGateway\PaymentGatewayInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;
use inklabs\kommerce\Lib\Event\LoggingEventDispatcher;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class OrderServiceTest extends ServiceTestCase
{
    /** @var OrderRepositoryInterface */
    protected $orderRepository;

    /** @var OrderItemRepositoryInterface */
    protected $orderItemRepository;

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    /** @var OrderServiceInterface */
    protected $orderService;

    /** @var ShipmentGatewayInterface */
    protected $shipmentGateway;

    /** @var LoggingEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var InventoryLocationRepositoryInterface */
    protected $inventoryLocationRepository;

    /** @var InventoryTransactionRepositoryInterface */
    protected $inventoryTransactionRepository;

    /** @var InventoryServiceInterface */
    protected $inventoryService;

    /** @var PaymentGatewayInterface */
    protected $paymentGateway;

    protected $metaDataClassNames = [
        Attachment::class,
        Cart::class,
        CartItem::class,
        CartItemOptionProduct::class,
        InventoryLocation::class,
        Option::class,
        OptionProduct::class,
        Order::class,
        OrderItem::class,
        OrderItemOptionProduct::class,
        AbstractPayment::class,
        Product::class,
        Shipment::class,
        ShipmentComment::class,
        ShipmentItem::class,
        ShipmentTracker::class,
        Tag::class,
        TaxRate::class,
        User::class,
        Warehouse::class,
    ];

    public function setUp()
    {
        parent::setUp();

        $this->fakeEventDispatcher = new LoggingEventDispatcher(new EventDispatcher());
        $this->orderRepository = $this->getRepositoryFactory()->getOrderRepository();
        $this->orderItemRepository = $this->getRepositoryFactory()->getOrderItemRepository();
        $this->productRepository = $this->getRepositoryFactory()->getProductRepository();
        $this->shipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);

        $this->inventoryLocationRepository = $this->getRepositoryFactory()->getInventoryLocationRepository();
        $this->inventoryTransactionRepository = $this->getRepositoryFactory()->getInventoryTransactionRepository();

        $warehouse = $this->getInitializeWarehouse();

        $this->inventoryService = new InventoryService(
            $this->inventoryLocationRepository,
            $this->inventoryTransactionRepository,
            $this->getInitializedHoldInventoryLocation($warehouse)->getId()
        );

        $this->paymentGateway = new FakePaymentGateway;

        $this->orderService = new OrderService(
            $this->fakeEventDispatcher,
            $this->inventoryService,
            $this->orderRepository,
            $this->orderItemRepository,
            $this->paymentGateway,
            $this->productRepository,
            $this->shipmentGateway
        );
    }

    public function testFind()
    {
        $order1 = $this->getPersistedOrderWith2Items();

        $order = $this->orderService->findOneById(
            $order1->getId()
        );

        $this->assertEntitiesEqual($order1, $order);
    }

    public function testGetOrderItem()
    {
        $order1 = $this->getPersistedOrderWith2Items();
        $orderItem1 = $order1->getOrderItems()[0];

        $orderItem = $this->orderService->getOrderItemById(
            $orderItem1->getId()
        );

        $this->assertEntitiesEqual($orderItem1, $orderItem);
    }

    public function testGetLatestOrders()
    {
        $order1 = $this->getPersistedOrderWith2Items();

        $orders = $this->orderService->getLatestOrders();

        $this->assertEntitiesEqual($order1, $orders[0]);
    }

    public function testGetOrderByUserId()
    {
        $order1 = $this->getPersistedOrderWith2Items();

        $orders = $this->orderService->getOrdersByUserId(
            $order1->getUser()->getId()
        );

        $this->assertEntitiesEqual($order1, $orders[0]);
    }

    public function testBuyShipmentLabel()
    {
        $order1 = $this->getPersistedOrderWith2Items();

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(
            $order1->getOrderItems()[0]->getId(),
            1
        );
        $comment = 'A comment';
        $rateExternalId = self::RATE_EXTERNAL_ID;
        $shipmentExternalId = self::SHIPMENT_EXTERNAL_ID;

        $this->orderService->buyShipmentLabel(
            $order1->getId(),
            $orderItemQtyDTO,
            $comment,
            $rateExternalId,
            $shipmentExternalId
        );

        $shipment = $order1->getShipments()[0];
        $shipmentComment = $shipment->getShipmentComments()[0];
        $shipmentTracker = $shipment->getShipmentTrackers()[0];
        $this->assertSame(1, count($order1->getShipments()));
        $this->assertSame('A comment', $shipmentComment->getComment());
        // TODO: Verify external Ids
        //$this->assertSame($rateExternalId, $shipmentTracker->getExternalId());
        //$this->assertSame($shipmentExternalId, $shipmentTracker->getShipmentRate()->getExternalId());
        $this->assertOrderShippedEventIsDispatched($order1, $shipment);
    }

    public function testAddShipmentTrackingCode()
    {
        $order1 = $this->getPersistedOrderWith2Items();
        $carrierType = $this->dummyData->getShipmentCarrierType();

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(
            $order1->getOrderItems()[0]->getId(),
            1
        );

        $comment = 'A comment';
        $trackingCode = self::SHIPMENT_TRACKING_CODE;

        $this->orderService->addShipmentTrackingCode(
            $order1->getId(),
            $orderItemQtyDTO,
            $comment,
            $carrierType->getId(),
            $trackingCode
        );

        $shipment = $order1->getShipments()[0];
        $shipmentComment = $shipment->getShipmentComments()[0];
        $shipmentTracker = $shipment->getShipmentTrackers()[0];
        $this->assertSame(1, count($order1->getShipments()));
        $this->assertSame(1, count($shipment->getShipmentItems()));
        $this->assertSame('A comment', $shipmentComment->getComment());
        $this->assertSame($trackingCode, $shipmentTracker->getTrackingCode());
        $this->assertOrderShippedEventIsDispatched($order1, $shipment);
    }

    public function testOrderMarkedAsShippedWhen2PartialShipmentsAreFullyShipped()
    {
        $order1 = $this->getPersistedOrderWith2Items();
        $orderItem1 = $order1->getOrderItems()[0];
        $orderItem2 = $order1->getOrderItems()[1];
        $carrierType = $this->dummyData->getShipmentCarrierType();

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(
            $orderItem1->getId(),
            1
        );

        $this->orderService->addShipmentTrackingCode(
            $order1->getId(),
            $orderItemQtyDTO,
            '1 of 2 items shipped',
            $carrierType->getId(),
            'XXXX'
        );

        $this->assertSame(1, count($order1->getShipments()));
        $this->assertTrue($order1->getStatus()->isPartiallyShipped());

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(
            $orderItem2->getId(),
            1
        );

        $this->orderService->addShipmentTrackingCode(
            $order1->getId(),
            $orderItemQtyDTO,
            '2 of 2 items shipped. This completes your order',
            $carrierType->getId(),
            'XXXX'
        );

        $this->assertSame(2, count($order1->getShipments()));
        $this->assertTrue($order1->getStatus()->isShipped());
    }

    public function testSetOrderStatus()
    {
        $order1 = $this->getPersistedOrderWith2Items();

        $this->orderService->setOrderStatus($order1->getId(), OrderStatusType::canceled());

        $this->assertTrue($order1->getStatus()->isCanceled());
    }

    public function testSetOrderStatusLocksAttachments()
    {
        $order1 = $this->getPersistedOrderWith2ItemsWithAttachments();

        $this->setCountLogger();

        $this->orderService->setOrderStatus($order1->getId(), OrderStatusType::canceled());

        $this->assertTrue($order1->getStatus()->isCanceled());
        $this->assertTrue($order1->getOrderItems()[0]->getAttachments()[0]->isLocked());
        $this->assertTrue($order1->getOrderItems()[1]->getAttachments()[0]->isLocked());
        $this->assertSame(10, $this->getTotalQueries());
    }

    public function testCreateOrderFromCart()
    {
        $cart = $this->getPersistedCart();
        $orderId = Uuid::uuid4();

        $order = $this->orderService->createOrderFromCart(
            $orderId,
            $cart->getUser(),
            $cart,
            $this->getCartCalculator(),
            '10.0.0.1',
            $this->dummyData->getOrderAddress(),
            $this->dummyData->getOrderAddress(),
            $this->dummyData->getCreditCard()
        );

        $this->assertTrue($order instanceof Order);
        $this->assertTrue($order->getPayments()[0] instanceof CreditPayment);

        // TODO: Test reserveProductsFromInventory

        /** @var OrderCreatedFromCartEvent $event */
        $event = $this->fakeEventDispatcher->getDispatchedEvents(OrderCreatedFromCartEvent::class)[0];
        $this->assertTrue($event instanceof OrderCreatedFromCartEvent);
        $this->assertSame($order->getId(), $event->getOrderId());
    }

    /**
     * @return Order
     */
    private function getPersistedOrderWith2Items()
    {
        $user = $this->dummyData->getUser();
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();
        $order1 = $this->dummyData->getOrder(null);
        $order1->setUser($user);

        $orderItem1 = $this->dummyData->getOrderItem($order1, $product1);
        $orderItem2 = $this->dummyData->getOrderItem($order1, $product2);

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($user);
        $this->entityManager->persist($order1);
        $this->entityManager->flush();

        return $order1;
    }

    /**
     * @return Order
     */
    private function getPersistedOrderWith2ItemsWithAttachments()
    {
        $attachment1 = $this->dummyData->getAttachment();
        $attachment2 = $this->dummyData->getAttachment();

        $attachment1->setUnlocked();
        $attachment2->setUnlocked();

        $user = $this->dummyData->getUser();
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();

        $product1->enableAttachments();
        $product2->enableAttachments();

        $order1 = $this->dummyData->getOrder(null);
        $order1->setUser($user);

        $orderItem1 = $this->dummyData->getOrderItem($order1, $product1);
        $orderItem2 = $this->dummyData->getOrderItem($order1, $product2);

        $orderItem1->addAttachment($attachment1);
        $orderItem2->addAttachment($attachment2);

        $this->entityManager->persist($attachment1);
        $this->entityManager->persist($attachment2);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($user);
        $this->entityManager->persist($order1);
        $this->entityManager->flush();

        return $order1;
    }

    private function assertOrderShippedEventIsDispatched(Order $order, Shipment $shipment)
    {
        /** @var OrderShippedEvent $event */
        $event = $this->fakeEventDispatcher->getDispatchedEvents(OrderShippedEvent::class)[0];
        $this->assertTrue($event instanceof OrderShippedEvent);
        $this->assertEquals($order->getId(), $event->getOrderId());
        $this->assertSame($shipment->getId(), $event->getShipmentId());
    }

    /**
     * @return \inklabs\kommerce\Entity\Cart
     */
    private function getPersistedCart()
    {
        $product1 = $this->dummyData->getProduct();
        $product1->setIsInventoryRequired(false);
        $product2 = $this->dummyData->getProduct();
        $product2->setIsInventoryRequired(false);
        $option = $this->dummyData->getOption();
        $optionProduct = $this->dummyData->getOptionProduct($option, $product2);
        $cartItemOptionProduct = $this->dummyData->getCartItemOptionProduct($optionProduct);
        $cartItem = $this->dummyData->getCartItem($product1);
        $cartItem->addCartItemOptionProduct($cartItemOptionProduct);
        $cart = $this->dummyData->getCart([
            $cartItem
        ]);
        $user = $this->dummyData->getUser();
        $cart->setUser($user);

        $this->entityManager->persist($option);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($user);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }
}
