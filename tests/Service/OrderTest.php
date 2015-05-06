<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeOrder;

class OrderTest extends Helper\DoctrineTestCase
{
    /** @var FakeOrder */
    protected $orderRepository;

    /** @var Order */
    protected $orderService;

    public function setUp()
    {
        $this->orderRepository = new FakeOrder;
        $this->orderService = new Order($this->orderRepository);
    }

    public function testFind()
    {
        $order = $this->orderService->find(1);
        $this->assertTrue($order instanceof View\Order);
    }

    public function testFindMissing()
    {
        $this->orderRepository->setReturnValue(null);

        $product = $this->orderService->find(0);
        $this->assertSame(null, $product);
    }

    public function testGetLatestOrders()
    {
        $orders = $this->orderService->getLatestOrders();
        $this->assertTrue($orders[0] instanceof View\Order);
    }

    public function testGetOrderByUserId()
    {
        $orders = $this->orderService->getOrdersByUserId(1);
        $this->assertTrue($orders[0] instanceof View\Order);
    }
}
