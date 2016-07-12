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
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class OrderItemTextOptionValueRepositoryTest extends EntityRepositoryTestCase
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

    public function testFind()
    {
        $originalOrderItemTextOptionValue = $this->setupOrderItemTextOptionValue();
        $this->setCountLogger();

        $orderItemTextOptionValue = $this->orderItemTextOptionValueRepository->findOneById(
            $originalOrderItemTextOptionValue->getId()
        );

        $orderItemTextOptionValue->getOrderItem()->getCreated();
        $orderItemTextOptionValue->getTextOption()->getCreated();

        $this->assertEquals($originalOrderItemTextOptionValue->getId(), $orderItemTextOptionValue->getId());
        $this->assertSame(3, $this->getTotalQueries());
    }

    private function setupOrderItemTextOptionValue()
    {
        $user = $this->dummyData->getUser();
        $cartTotal = $this->dummyData->getCartTotal();
        $order = $this->dummyData->getOrder($cartTotal);
        $order->setUser($user);

        $textOption = $this->dummyData->getTextOption();
        $orderItemTextOptionValue = $this->dummyData->getOrderItemTextOptionValue($textOption, 'Happy Birthday');

        $product = $this->dummyData->getProduct();
        $price = $this->dummyData->getPrice();

        $orderItem = $this->dummyData->getOrderItem($order, $product, $price);
        $orderItem->addOrderItemTextOptionValue($orderItemTextOptionValue);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($textOption);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $orderItemTextOptionValue;
    }
}
