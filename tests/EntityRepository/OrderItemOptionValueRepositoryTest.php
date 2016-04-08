<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class OrderItemOptionValueRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        OptionValue::class,
        Order::class,
        OrderItem::class,
        OrderItemOptionValue::class,
        Product::class,
        User::class,
        Cart::class,
        TaxRate::class,
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
