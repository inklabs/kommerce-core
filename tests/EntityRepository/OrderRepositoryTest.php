<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Lib\ReferenceNumber\HashSegmentGenerator;
use inklabs\kommerce\tests\Helper;

class OrderRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Coupon',
        'kommerce:Order',
        'kommerce:OrderItem',
        'kommerce:AbstractPayment',
        'kommerce:Product',
        'kommerce:User',
        'kommerce:Cart',
        'kommerce:TaxRate',
    ];

    /** @var OrderRepository */
    protected $orderRepository;

    public function setUp()
    {
        $this->orderRepository = $this->getRepositoryFactory()->getOrderRepository();
    }

    public function setupOrder($referenceNumber = null)
    {
        $uniqueId = crc32($referenceNumber);

        $product = $this->getDummyProduct($uniqueId);
        $price = $this->getDummyPrice();

        $user = $this->getDummyUser($uniqueId);
        $orderItem = $this->getDummyOrderItem($product, $price);
        $cartTotal = $this->getDummyCartTotal();

        $taxRate = $this->getDummyTaxRate();

        $order = $this->getDummyOrder($cartTotal, [$orderItem]);
        $order->setUser($user);
        $order->setReferenceNumber($referenceNumber);
        $order->setTaxRate($taxRate);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($taxRate);

        $this->orderRepository->create($order);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $order;
    }

    public function testCRUD()
    {
        $order = $this->setupOrder();

        $order->setExternalId('newExternalId');
        $this->assertSame(null, $order->getUpdated());
        $this->orderRepository->update($order);
        $this->assertTrue($order->getUpdated() instanceof \DateTime);

        $this->orderRepository->delete($order);
        $this->assertSame(null, $order->getId());
    }

    public function testFindOneById()
    {
        $this->setupOrder();

        $this->setCountLogger();

        $order = $this->orderRepository->findOneById(1);

        $order->getOrderItems()->toArray();
        $order->getPayments()->toArray();
        $order->getUser()->getCreated();
        $order->getCoupons()->toArray();
        $order->getTaxRate()->getCreated();

        $this->assertTrue($order instanceof Order);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }

    /**
     * @expectedException \inklabs\kommerce\EntityRepository\EntityNotFoundException
     * @expectedExceptionMessage Order not found
     */
    public function testFindOneByIdThrowsException()
    {
        $this->orderRepository->findOneById(1);
    }

    public function testGetLatestOrders()
    {
        $this->setupOrder();

        $orders = $this->orderRepository->getLatestOrders();

        $this->assertTrue($orders[0] instanceof Order);
    }

    public function testCreateWithSequentialReferenceNumber()
    {
        $this->orderRepository = $this->getRepositoryFactory()->getOrderWithSequentialGenerator();

        $order = $this->setupOrder();

        $this->assertSame(1, $order->getId());
        $this->assertSame('0000000001', $order->getReferenceNumber());
    }

    public function testCreateWithHashReferenceNumber()
    {
        mt_srand(0);

        $this->orderRepository = $this->getRepositoryFactory()->getOrderWithHashSegmentGenerator();

        $order = $this->setupOrder();

        $this->assertSame(1, $order->getId());
        $this->assertSame('963-1273124-1535857', $order->getReferenceNumber());
    }

    public function testCreateWithHashReferenceNumberAndDuplicateFailure()
    {
        mt_srand(0);

        // Simulate 3 duplicates in a row.
        $this->setupOrder('963-1273124-1535857');
        $this->setupOrder('324-1294424-1842424');
        $this->setupOrder('117-1819459-9097917');

        $this->orderRepository->setReferenceNumberGenerator(
            new HashSegmentGenerator($this->orderRepository)
        );

        $order = $this->setupOrder();

        $this->assertSame(4, $order->getId());
        $this->assertSame(null, $order->getReferenceNumber());
    }

    public function testGetOrdersByUserId()
    {
        $this->setupOrder();

        $orders = $this->orderRepository->getOrdersByUserId(1);

        $this->assertTrue($orders[0] instanceof Order);
        $this->assertSame(1, $orders[0]->getUser()->getId());
    }
}
