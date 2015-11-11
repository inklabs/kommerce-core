<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Event\OrderShippedEvent;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\Entity\FakeEventDispatcher;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderItemRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\Lib\ShipmentGateway\FakeShipmentGateway;

class OrderServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeOrderRepository */
    protected $orderRepository;

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

    public function setUp()
    {
        parent::setUp();

        $this->fakeEventDispatcher = new FakeEventDispatcher;
        $this->orderRepository = new FakeOrderRepository;
        $this->orderItemRepository = new FakeOrderItemRepository;
        $this->productRepository = new FakeProductRepository;
        $this->shipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);

        $this->orderService = new OrderService(
            $this->fakeEventDispatcher,
            $this->orderRepository,
            $this->orderItemRepository,
            $this->productRepository,
            $this->shipmentGateway
        );
    }

    public function testFind()
    {
        $this->orderRepository->create(new Order);

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
        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(1, 1);
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
        $this->assertSame('A comment', $order->getShipments()[0]->getShipmentComments()[0]->getComment());
        $this->assertOrderShippedEventIsDipatched();
    }

    public function testSetOrderStatus()
    {
        $order = $this->getPersistedDummyOrder();
        $this->orderService->setOrderStatus($order->getId(), Order::STATUS_CANCELED);
        $this->assertSame(Order::STATUS_CANCELED, $order->getStatus());
    }

    /**
     * @return Order
     */
    private function getPersistedDummyOrder()
    {
        $order = $this->dummyData->getOrderFull();
        $this->orderRepository->create($order);

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
    }
}
