<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;

class OrderItemOptionProductTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Option',
        'kommerce:OptionProduct',
        'kommerce:Order',
        'kommerce:OrderItem',
        'kommerce:OrderItemOptionProduct',
        'kommerce:Product',
        'kommerce:User',
        'kommerce:Cart',
    ];

    /** @var OrderItemOptionProductInterface */
    protected $orderItemOptionProductRepository;

    public function setUp()
    {
        $this->orderItemOptionProductRepository = $this->getOrderItemOptionProductRepository();
    }

    public function setupOrder()
    {
        $product2 = $this->getDummyProduct();
        $option = $this->getDummyOption();
        $optionProduct = $this->getDummyOptionProduct($option, $product2);
        $orderItemOptionProduct = $this->getDummyOrderItemOptionProduct($optionProduct);

        $product = $this->getDummyProduct(1);
        $price = $this->getDummyPrice();

        $orderItem = $this->getDummyOrderItem($product, $price);
        $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);

        $cartTotal = $this->getDummyCartTotal();

        $user = $this->getDummyUser();
        $order = $this->getDummyOrder($cartTotal, [$orderItem]);
        $order->setUser($user);

        $this->entityManager->persist($product);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($user);
        $this->entityManager->persist($option);
        $this->entityManager->persist($optionProduct);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOrder();

        $this->setCountLogger();

        $orderItemOptionProduct = $this->orderItemOptionProductRepository->find(1);

        $orderItemOptionProduct->getOrderItem()->getCreated();
        $orderItemOptionProduct->getOptionProduct()->getCreated();

        $this->assertTrue($orderItemOptionProduct instanceof Entity\OrderItemOptionProduct);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }
}
