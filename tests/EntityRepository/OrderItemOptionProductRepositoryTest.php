<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class OrderItemOptionProductRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Option::class,
        OptionProduct::class,
        Order::class,
        OrderItem::class,
        OrderItemOptionProduct::class,
        Product::class,
        User::class,
        Cart::class,
        TaxRate::class,
    ];

    /** @var OrderItemOptionProductRepositoryInterface */
    protected $orderItemOptionProductRepository;

    public function setUp()
    {
        parent::setUp();
        $this->orderItemOptionProductRepository = $this->getRepositoryFactory()->getOrderItemOptionProductRepository();
    }

    public function testFind()
    {
        $originalOrderItemOptionProduct = $this->setupOrderItemOptionProduct();
        $this->setCountLogger();

        $orderItemOptionProduct = $this->orderItemOptionProductRepository->findOneById(
            $originalOrderItemOptionProduct->getId()
        );

        $orderItemOptionProduct->getOrderItem()->getCreated();
        $orderItemOptionProduct->getOptionProduct()->getCreated();

        $this->assertTrue($orderItemOptionProduct instanceof OrderItemOptionProduct);
        $this->assertSame(4, $this->getTotalQueries());
    }

    private function setupOrderItemOptionProduct()
    {
        $product2 = $this->dummyData->getProduct();
        $option = $this->dummyData->getOption();
        $optionProduct = $this->dummyData->getOptionProduct($option, $product2);
        $orderItemOptionProduct = $this->dummyData->getOrderItemOptionProduct($optionProduct);

        $product = $this->dummyData->getProduct();
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

        return $orderItemOptionProduct;
    }
}
