<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\tests\Helper;

class OrderItemTextOptionValueRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:TextOption',
        'kommerce:Order',
        'kommerce:OrderItem',
        'kommerce:OrderItemTextOptionValue',
        'kommerce:Product',
        'kommerce:User',
        'kommerce:Cart',
        'kommerce:TaxRate',
    ];

    /** @var OrderItemTextOptionValueRepositoryInterface */
    protected $orderItemTextOptionValueRepository;

    public function setUp()
    {
        $this->orderItemTextOptionValueRepository = $this->repository()->getOrderItemTextOptionValueRepository();
    }

    public function setupOrder()
    {
        $textOption = $this->getDummyTextOption();
        $orderItemTextOptionValue = $this->getDummyOrderItemTextOptionValue($textOption, 'Happy Birthday');

        $product = $this->getDummyProduct(1);
        $price = $this->getDummyPrice();

        $orderItem = $this->getDummyOrderItem($product, $price);
        $orderItem->addOrderItemTextOptionValue($orderItemTextOptionValue);

        $cartTotal = $this->getDummyCartTotal();

        $user = $this->getDummyUser();
        $order = $this->getDummyOrder($cartTotal, [$orderItem]);
        $order->setUser($user);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($textOption);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOrder();

        $this->setCountLogger();

        $orderItemTextOptionValue = $this->orderItemTextOptionValueRepository->find(1);

        $orderItemTextOptionValue->getOrderItem()->getCreated();
        $orderItemTextOptionValue->getTextOption()->getCreated();

        $this->assertTrue($orderItemTextOptionValue instanceof OrderItemTextOptionValue);
        $this->assertSame(4, $this->countSQLLogger->getTotalQueries());
    }
}
