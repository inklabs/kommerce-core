<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\Entity\CreditPayment;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Event\OrderCreatedFromCartEvent;
use inklabs\kommerce\Event\OrderShippedEvent;
use inklabs\kommerce\Lib\PaymentGateway\FakePaymentGateway;
use inklabs\kommerce\Lib\PaymentGateway\PaymentGatewayInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeInventoryLocationRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeInventoryTransactionRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderItemRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class OrderServiceTest extends ServiceTestCase
{
    /** @var FakeOrderRepository */
    protected $fakeOrderRepository;

    /** @var FakeOrderItemRepository */
    protected $orderItemRepository;

    /** @var FakeProductRepository */
    protected $productRepository;

    /** @var OrderService */
    protected $orderService;

    /** @var ShipmentGatewayInterface */
    protected $shipmentGateway;

    /** @var FakeEventDispatcher */
    protected $fakeEventDispatcher;

    /** @var FakeInventoryLocationRepository */
    protected $fakeInventoryLocationRepository;

    /** @var FakeInventoryTransactionRepository */
    protected $fakeInventoryTransactionRepository;

    /** @var InventoryServiceInterface */
    protected $inventoryService;

    /** @var PaymentGatewayInterface */
    protected $paymentGateway;

    public function setUp()
    {
        parent::setUp();

        $this->fakeEventDispatcher = new FakeEventDispatcher;
        $this->fakeOrderRepository = new FakeOrderRepository;
        $this->orderItemRepository = new FakeOrderItemRepository;
        $this->productRepository = new FakeProductRepository;
        $this->shipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);

        $this->fakeInventoryLocationRepository = new FakeInventoryLocationRepository;
        $this->fakeInventoryTransactionRepository = new FakeInventoryTransactionRepository;

        $this->inventoryService = new InventoryService(
            $this->fakeInventoryLocationRepository,
            $this->fakeInventoryTransactionRepository
        );

        $this->paymentGateway = new FakePaymentGateway;

        $this->orderService = $this->getOrderService();
    }

    private function getOrderService()
    {
        return new OrderService(
            $this->fakeEventDispatcher,
            $this->inventoryService,
            $this->fakeOrderRepository,
            $this->orderItemRepository,
            $this->paymentGateway,
            $this->productRepository,
            $this->shipmentGateway
        );
    }

    public function testFind()
    {
        $this->fakeOrderRepository->create(new Order);
        $order = $this->orderService->findOneById(1);
        $this->assertTrue($order instanceof Order);
    }

    public function testGetLatestOrders()
    {
        $orders = $this->orderService->getLatestOrders();
        $this->assertTrue($orders[0] instanceof Order);
    }

    public function testGetOrderByUserId()
    {
        $orders = $this->orderService->getOrdersByUserId(1);
        $this->assertTrue($orders[0] instanceof Order);
    }

    public function testBuyShipmentLabel()
    {
        $order = $this->getPersistedDummyOrder();
        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(1, 1);
        $comment = 'A comment';
        $rateExternalId = 'rate_xxxxx';
        $shipmentExternalId = 'shp_xxxxx';

        $this->orderService->buyShipmentLabel(
            $order->getId(),
            $orderItemQtyDTO,
            $comment,
            $rateExternalId,
            $shipmentExternalId
        );

        $this->assertSame(1, count($order->getShipments()));
        $this->assertSame('A comment', $order->getShipments()[0]->getShipmentComments()[0]->getComment());
        $this->assertOrderShippedEventIsDipatched();
    }

    public function testAddShipmentTrackingCode()
    {
        $order = $this->getPersistedDummyOrder();
        $orderItem2 = $this->dummyData->getOrderItemFull();
        $this->orderItemRepository->create($orderItem2);
        $order->addOrderItem($orderItem2);

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(1, 1);
        $orderItemQtyDTO->addOrderItemQty(2, 0);

        $comment = 'A comment';
        $carrier = ShipmentTracker::CARRIER_UNKNOWN;
        $trackingCode = 'XXXX';

        $this->orderService->addShipmentTrackingCode(
            $order->getId(),
            $orderItemQtyDTO,
            $comment,
            $carrier,
            $trackingCode
        );

        $this->assertSame(1, count($order->getShipments()));
        $this->assertSame(1, count($order->getShipments()[0]->getShipmentItems()));
        $this->assertSame('A comment', $order->getShipments()[0]->getShipmentComments()[0]->getComment());
        $this->assertOrderShippedEventIsDipatched();
    }

    public function testOrderMarkedAsShippedWhen2PartialShipmentsAreFullyShipped()
    {
        $order = $this->getPersistedDummyOrder();
        $orderItem2 = $this->dummyData->getOrderItemFull();
        $this->orderItemRepository->create($orderItem2);
        $order->addOrderItem($orderItem2);

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty($order->getOrderItem(0)->getId(), 1);
        $this->orderService->addShipmentTrackingCode(
            $order->getId(),
            $orderItemQtyDTO,
            '1 of 2 items shipped',
            ShipmentTracker::CARRIER_UNKNOWN,
            'XXXX'
        );

        $this->assertSame(1, count($order->getShipments()));
        $this->assertTrue($order->getStatus()->isPartiallyShipped());

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty($order->getOrderItem(1)->getId(), 1);
        $this->orderService->addShipmentTrackingCode(
            $order->getId(),
            $orderItemQtyDTO,
            '2 of 2 items shipped. This completes your order',
            ShipmentTracker::CARRIER_UNKNOWN,
            'XXXX'
        );

        $this->assertSame(2, count($order->getShipments()));
        $this->assertTrue($order->getStatus()->isShipped());
    }

    public function testSetOrderStatus()
    {
        $order = $this->getPersistedDummyOrder();
        $this->orderService->setOrderStatus($order->getId(), OrderStatusType::canceled());
        $this->assertTrue($order->getStatus()->isCanceled());
    }

    /**
     * @return Order
     */
    private function getPersistedDummyOrder()
    {
        $order = $this->dummyData->getOrderFullWithoutShipments();
        $this->fakeOrderRepository->create($order);

        foreach ($order->getOrderItems() as $orderItem) {
            $this->orderItemRepository->create($orderItem);
        }

        return $order;
    }

    private function assertOrderShippedEventIsDipatched()
    {
        /** @var OrderShippedEvent $event */
        $event = $this->fakeEventDispatcher->getDispatchedEvents(OrderShippedEvent::class)[0];
        $this->assertTrue($event instanceof OrderShippedEvent);
        $this->assertSame(1, $event->getOrderId());
        $this->assertSame(1, $event->getShipmentId());
    }

    public function testCreateOrderFromCart()
    {
        $cart = $this->dummyData->getCart();
        $product = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem($product);
        $cartItem->addCartItemOptionProduct($this->dummyData->getCartItemOptionProduct());
        $cart->addCartItem($cartItem);
        $cart->setUser($this->dummyData->getUser());

        $this->inventoryService = $this->mockService->getInventoryService();
        $this->inventoryService->shouldReceive('reserveProduct')
            ->times(2);

        $order = $this->getOrderService()->createOrderFromCart(
            $cart,
            $this->getCartCalculator(),
            '10.0.0.1',
            $this->dummyData->getOrderAddress(),
            $this->dummyData->getOrderAddress(),
            $this->dummyData->getCreditCard()
        );

        $this->assertTrue($order instanceof Order);
        $this->assertTrue($order->getPayments()[0] instanceof CreditPayment);

        /** @var OrderCreatedFromCartEvent $event */
        $event = $this->fakeEventDispatcher->getDispatchedEvents(OrderCreatedFromCartEvent::class)[0];
        $this->assertTrue($event instanceof OrderCreatedFromCartEvent);
        $this->assertSame(1, $event->getOrderId());
    }
}
