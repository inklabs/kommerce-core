<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\tests\Helper;

class OrderItemOptionProductRepositoryTest extends Helper\DoctrineTestCase
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
        'kommerce:TaxRate',
    ];

    /** @var OrderItemOptionProductRepositoryInterface */
    protected $orderItemOptionProductRepository;

    public function setUp()
    {
        parent::setUp();
        $this->orderItemOptionProductRepository = $this->getRepositoryFactory()->getOrderItemOptionProductRepository();
    }

    public function setupOrder()
    {
        $product2 = $this->dummyData->getProduct(2);
        $option = $this->dummyData->getOption();
        $optionProduct = $this->dummyData->getOptionProduct($option, $product2);
        $orderItemOptionProduct = $this->dummyData->getOrderItemOptionProduct($optionProduct);

        $product = $this->dummyData->getProduct(1);
        $price = $this->dummyData->getPrice();

        $orderItem = $this->dummyData->getOrderItem($product, $price);
        $orderItem->addOrderItemOptionProduct($orderItemOptionProduct);

        $cartTotal = $this->dummyData->getCartTotal();

        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder($cartTotal, [$orderItem]);
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

        $orderItemOptionProduct = $this->orderItemOptionProductRepository->findOneById(1);

        $orderItemOptionProduct->getOrderItem()->getCreated();
        $orderItemOptionProduct->getOptionProduct()->getCreated();

        $this->assertTrue($orderItemOptionProduct instanceof OrderItemOptionProduct);
        $this->assertSame(5, $this->getTotalQueries());
    }
}
