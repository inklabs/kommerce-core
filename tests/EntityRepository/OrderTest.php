<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;

class OrderTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Coupon',
        'kommerce:Order',
        'kommerce:OrderItem',
        'kommerce:Payment\Payment',
        'kommerce:Product',
        'kommerce:User',
        'kommerce:Cart',
    ];

    /** @var Order */
    protected $orderRepository;

    public function setUp()
    {
        $this->orderRepository = $this->entityManager->getRepository('kommerce:Order');
    }

    public function setupOrder()
    {
        $product = $this->getDummyProduct();
        $price = $this->getDummyPrice();

        $user = $this->getDummyUser();
        $orderItem = $this->getDummyOrderItem($product, $price);
        $cartTotal = $this->getDummyCartTotal();

        $order = $this->getDummyOrder($cartTotal, [$orderItem]);
        $order->setUser($user);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);

        $this->orderRepository->create($order);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $order;
    }

    public function testFind()
    {
        $this->setupOrder();

        $this->setCountLogger();

        $order = $this->orderRepository->find(1);

        $order->getOrderItems()->toArray();
        $order->getPayments()->toArray();
        $order->getUser()->getCreated();
        $order->getCoupons()->toArray();

        $this->assertTrue($order instanceof Entity\Order);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetLatestOrders()
    {
        $this->setupOrder();

        $orders = $this->orderRepository->getLatestOrders();

        $this->assertTrue($orders[0] instanceof Entity\Order);
    }

    public function testSave()
    {
        $order = $this->setupOrder();

        $order->setExternalId('newExternalId');
        $this->assertSame(null, $order->getUpdated());
        $this->orderRepository->save($order);
        $this->assertTrue($order->getUpdated() instanceof \DateTime);
    }
}
