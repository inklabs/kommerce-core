<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper;

class OrderItemTextOptionValueRepositoryTest extends Helper\TestCase\EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        TextOption::class,
        Order::class,
        OrderItem::class,
        OrderItemTextOptionValue::class,
        Product::class,
        User::class,
        Cart::class,
        TaxRate::class,
    ];

    /** @var OrderItemTextOptionValueRepositoryInterface */
    protected $orderItemTextOptionValueRepository;

    public function setUp()
    {
        parent::setUp();
        $this->orderItemTextOptionValueRepository = $this->getRepositoryFactory()
            ->getOrderItemTextOptionValueRepository();
    }

    public function setupOrder()
    {
        $textOption = $this->dummyData->getTextOption();
        $orderItemTextOptionValue = $this->dummyData->getOrderItemTextOptionValue($textOption, 'Happy Birthday');

        $product = $this->dummyData->getProduct(1);
        $price = $this->dummyData->getPrice();

        $orderItem = $this->dummyData->getOrderItem($product, $price);
        $orderItem->addOrderItemTextOptionValue($orderItemTextOptionValue);

        $cartTotal = $this->dummyData->getCartTotal();

        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder($cartTotal, [$orderItem]);
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

        $orderItemTextOptionValue = $this->orderItemTextOptionValueRepository->findOneById(1);

        $orderItemTextOptionValue->getOrderItem()->getCreated();
        $orderItemTextOptionValue->getTextOption()->getCreated();

        $this->assertTrue($orderItemTextOptionValue instanceof OrderItemTextOptionValue);
        $this->assertSame(4, $this->getTotalQueries());
    }
}
