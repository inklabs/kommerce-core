<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;

class OrderItemOptionValueTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Option',
        'kommerce:OptionValue',
        'kommerce:Order',
        'kommerce:OrderItem',
        'kommerce:OrderItemOptionValue',
        'kommerce:Product',
        'kommerce:User',
    ];

    /**
     * @return OrderItemOptionValue
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:OrderItemOptionValue');
    }

    public function setupOrder()
    {
        $option = $this->getDummyOption();
        $optionValue = $this->getDummyOptionValue($option);
        $orderItemOptionValue = $this->getDummyOrderItemOptionValue($optionValue);

        $product = $this->getDummyProduct(1);
        $price = $this->getDummyPrice();

        $orderItem = $this->getDummyOrderItem($product, $price);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);

        $cartTotal = $this->getDummyCartTotal();

        $user = $this->getDummyUser();
        $order = $this->getDummyOrder($cartTotal, [$orderItem]);
        $order->setUser($user);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($option);
        $this->entityManager->persist($optionValue);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOrder();

        $this->setCountLogger();

        $orderItemOptionValue = $this->getRepository()
            ->find(1);

        $orderItemOptionValue->getOrderItem()->getCreated();
        $orderItemOptionValue->getOptionValue()->getCreated();

        $this->assertTrue($orderItemOptionValue instanceof Entity\OrderItemOptionValue);
        $this->assertSame(4, $this->countSQLLogger->getTotalQueries());
    }
}
