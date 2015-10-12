<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\tests\Helper;

class OrderItemOptionValueRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Option',
        'kommerce:OptionValue',
        'kommerce:Order',
        'kommerce:OrderItem',
        'kommerce:OrderItemOptionValue',
        'kommerce:Product',
        'kommerce:User',
        'kommerce:Cart',
        'kommerce:TaxRate',
    ];

    /** @var OrderItemOptionValueRepositoryInterface */
    protected $orderItemOptionValue;

    public function setUp()
    {
        $this->orderItemOptionValue = $this->getRepositoryFactory()->getOrderItemOptionValueRepository();
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

        $orderItemOptionValue = $this->orderItemOptionValue->findOneById(1);

        $orderItemOptionValue->getOrderItem()->getCreated();
        $orderItemOptionValue->getOptionValue()->getCreated();

        $this->assertTrue($orderItemOptionValue instanceof OrderItemOptionValue);
        $this->assertSame(5, $this->getTotalQueries());
    }
}
