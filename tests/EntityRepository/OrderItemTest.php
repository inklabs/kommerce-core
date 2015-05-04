<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;

class OrderItemTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:OptionProduct',
        'kommerce:OptionValue',
        'kommerce:TextOption',
        'kommerce:Order',
        'kommerce:OrderItem',
        'kommerce:OrderItemOptionProduct',
        'kommerce:OrderItemOptionValue',
        'kommerce:OrderItemTextOptionValue',
        'kommerce:Product',
        'kommerce:ProductQuantityDiscount',
        'kommerce:CatalogPromotion',
        'kommerce:Tag',
        'kommerce:User',
        'kommerce:Cart',
    ];

    /** @var OrderItemInterface */
    protected $orderItemRepository;

    public function setUp()
    {
        $this->orderItemRepository = $this->repository()->getOrderItem();
    }

    public function setupOrderItem()
    {
        $catalogPromotion = $this->getDummyCatalogPromotion();

        $product = $this->getDummyProduct();
        $productQuantityDiscount = $this->getDummyProductQuantityDiscount();
        $productQuantityDiscount->setProduct($product);

        $price = $this->getDummyPrice();
        $price->addCatalogPromotion($catalogPromotion);
        $price->addProductQuantityDiscount($productQuantityDiscount);

        $user = $this->getDummyUser();
        $orderItem = $this->getDummyOrderItem($product, $price);
        $cartTotal = $this->getDummyCartTotal();

        $order = $this->getDummyOrder($cartTotal, [$orderItem]);
        $order->setUser($user);

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->persist($productQuantityDiscount);
        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($order);

        $this->orderItemRepository->create($orderItem);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $orderItem;
    }

    public function testFind()
    {
        $this->setupOrderItem();

        $this->setCountLogger();

        $orderItem = $this->orderItemRepository->find(1);

        $orderItem->getProduct()->getCreated();
        $orderItem->getOrder()->getCreated();
        $orderItem->getCatalogPromotions()->toArray();
        $orderItem->getProductQuantityDiscounts()->toArray();
        $orderItem->getOrderItemOptionProducts()->toArray();
        $orderItem->getOrderItemOptionValues()->toArray();
        $orderItem->getOrderItemTextOptionValues()->toArray();

        $this->assertTrue($orderItem instanceof Entity\OrderItem);
        $this->assertSame(7, $this->countSQLLogger->getTotalQueries());
    }

    public function testSave()
    {
        $orderItem = $this->setupOrderItem();

        $orderItem->setQuantity(5);
        $this->assertSame(null, $orderItem->getUpdated());
        $this->orderItemRepository->save($orderItem);
        $this->assertTrue($orderItem->getUpdated() instanceof \DateTime);
    }
}
