<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;
use inklabs\kommerce\tests\Helper as Helper;

class OrderTest extends Helper\DoctrineTestCase
{
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

        $order = $this->getDummyOrder([$orderItem], $cartTotal);
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

        $order->getItems()->toArray();
        $order->getpayments()->toArray();
        $order->getUser()->getEmail();
        $order->getCoupons()->toArray();

        $this->assertTrue($order instanceof Entity\Order);
        $this->assertSame(4, $this->countSQLLogger->getTotalQueries());
    }
}
