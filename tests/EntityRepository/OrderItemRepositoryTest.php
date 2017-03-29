<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class OrderItemRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        OptionProduct::class,
        OptionValue::class,
        TextOption::class,
        Order::class,
        OrderItem::class,
        OrderItemOptionProduct::class,
        OrderItemOptionValue::class,
        OrderItemTextOptionValue::class,
        Product::class,
        ProductQuantityDiscount::class,
        CatalogPromotion::class,
        Tag::class,
        User::class,
        Cart::class,
    ];

    /** @var OrderItemRepositoryInterface */
    protected $orderItemRepository;

    public function setUp()
    {
        parent::setUp();
        $this->orderItemRepository = $this->getRepositoryFactory()->getOrderItemRepository();
    }

    public function testFind()
    {
        $originalOrderItem = $this->setupOrderItem();
        $this->entityManager->clear();

        $this->setCountLogger();

        $orderItem = $this->orderItemRepository->findOneById(
            $originalOrderItem->getId()
        );

        $orderItem->getProduct()->getCreated();
        $orderItem->getOrder()->getCreated();
        $this->visitElements($orderItem->getCatalogPromotions());
        $this->visitElements($orderItem->getProductQuantityDiscounts());
        $this->visitElements($orderItem->getOrderItemOptionProducts());
        $this->visitElements($orderItem->getOrderItemOptionValues());
        $this->visitElements($orderItem->getOrderItemTextOptionValues());

        $this->assertEquals($originalOrderItem->getId(), $orderItem->getId());
        $this->assertSame(7, $this->getTotalQueries());
    }

    private function setupOrderItem()
    {
        $user = $this->dummyData->getUser();
        $cartTotal = $this->dummyData->getCartTotal();

        $order = $this->dummyData->getOrder($cartTotal);
        $order->setUser($user);

        $catalogPromotion = $this->dummyData->getCatalogPromotion();

        $product = $this->dummyData->getProduct();
        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount($product);

        $price = $this->dummyData->getPrice();
        $price->addCatalogPromotion($catalogPromotion);
        $price->addProductQuantityDiscount($productQuantityDiscount);

        $orderItem = $this->dummyData->getOrderItem($order, $product, $price);

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->persist($productQuantityDiscount);
        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($order);

        $this->orderItemRepository->create($orderItem);

        $this->entityManager->flush();

        return $orderItem;
    }
}
