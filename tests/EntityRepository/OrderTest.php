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

    /**
     * @return Order
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Order');
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
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOrder();

        $this->setCountLogger();

        $order = $this->getRepository()
            ->find(1);

        $order->getOrderItems()->toArray();
        $order->getPayments()->toArray();
        $order->getUser()->getCreated();
        $order->getCoupons()->toArray();

        $this->assertTrue($order instanceof Entity\Order);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }
}
