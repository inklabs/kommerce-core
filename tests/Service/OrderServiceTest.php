<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrderRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;

class OrderServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeOrderRepository */
    protected $orderRepository;

    /** @var FakeProductRepository */
    protected $productRepository;

    /** @var OrderService */
    protected $orderService;

    public function setUp()
    {
        $this->orderRepository = new FakeOrderRepository;
        $this->productRepository = new FakeProductRepository;

        $this->orderService = new OrderService(
            $this->orderRepository,
            $this->productRepository
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
}
