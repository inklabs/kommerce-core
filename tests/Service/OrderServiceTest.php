<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\tests\Helper;
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

    public function setUp()
    {
        parent::setUp();

        $this->orderRepository = new FakeOrderRepository;
        $this->orderItemRepository = new FakeOrderItemRepository;
        $this->productRepository = new FakeProductRepository;
        $this->shipmentGateway = new FakeShipmentGateway(new OrderAddressDTO);

        $this->orderService = new OrderService(
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

    public function testAddShipment()
    {
        $this->setupEntityManager([
            'kommerce:Order',
            'kommerce:OrderItem',
            'kommerce:Product',
            'kommerce:Shipment',
            'kommerce:ShipmentTracker',
            'kommerce:ShipmentItem',
            'kommerce:ShipmentComment',
        ]);

        $order = $this->dummyData->getOrder($this->dummyData->getCartTotal());
        $product = $this->dummyData->getProduct(1);
        $orderItem = $this->dummyData->getOrderItem($product, $this->dummyData->getPrice());
        $order->addOrderItem($orderItem);
        $this->getRepositoryFactory()->getProductRepository()->create($product);
        $this->getRepositoryFactory()->getOrderRepository()->create($order);

        $orderId = $order->getId();
        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(1, 1);
        $rateExternalId = 'rate_xxxxx';
        $shipmentExternalId = 'shp_xxxxx';

        $this->getServiceFactory()->getOrder()->addShipment(
            $orderId,
            $orderItemQtyDTO,
            'A comment',
            $rateExternalId,
            $shipmentExternalId
        );

        $this->assertSame(1, $order->getId());
        $this->assertSame(1, $order->getShipments()[0]->getId());
        $this->assertSame(1, $order->getShipments()[0]->getShipmentItems()[0]->getId());
        $this->assertSame('A comment', $order->getShipments()[0]->getShipmentComments()[0]->getComment());
    }
}
