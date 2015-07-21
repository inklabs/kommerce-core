<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrder;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProduct;

class OrderTest extends Helper\DoctrineTestCase
{
    /** @var FakeOrder */
    protected $orderRepository;

    /** @var FakeProduct */
    protected $productRepository;

    /** @var Order */
    protected $orderService;

    public function setUp()
    {
        $this->orderRepository = new FakeOrder;
        $this->productRepository = new FakeProduct;

        $this->orderService = new Order(
            $this->orderRepository,
            $this->productRepository
        );
    }

    public function testFind()
    {
        $order = $this->orderService->find(1);
        $this->assertTrue($order instanceof Entity\Order);
    }

    public function testGetLatestOrders()
    {
        $orders = $this->orderService->getLatestOrders();
        $this->assertTrue($orders[0] instanceof Entity\Order);
    }

    public function testGetOrderByUserId()
    {
        $orders = $this->orderService->getOrdersByUserId(1);
        $this->assertTrue($orders[0] instanceof Entity\Order);
    }
}
