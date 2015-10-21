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
        parent::setUp();
        $this->orderItemOptionValue = $this->getRepositoryFactory()->getOrderItemOptionValueRepository();
    }

    public function setupOrder()
    {
        $option = $this->dummyData->getOption();
        $optionValue = $this->dummyData->getOptionValue($option);
        $orderItemOptionValue = $this->dummyData->getOrderItemOptionValue($optionValue);

        $product = $this->dummyData->getProduct(1);
        $price = $this->dummyData->getPrice();

        $orderItem = $this->dummyData->getOrderItem($product, $price);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);

        $cartTotal = $this->dummyData->getCartTotal();

        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder($cartTotal, [$orderItem]);
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
