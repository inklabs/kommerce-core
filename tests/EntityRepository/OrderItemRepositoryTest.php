<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\tests\Helper;

class OrderItemRepositoryTest extends Helper\DoctrineTestCase
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

    /** @var OrderItemRepositoryInterface */
    protected $orderItemRepository;

    public function setUp()
    {
        $this->orderItemRepository = $this->getRepositoryFactory()->getOrderItemRepository();
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

    public function testCRUD()
    {
        $orderItem = $this->setupOrderItem();

        $orderItem->setQuantity(5);
        $this->assertSame(null, $orderItem->getUpdated());
        $this->orderItemRepository->update($orderItem);
        $this->assertTrue($orderItem->getUpdated() instanceof \DateTime);

        $this->orderItemRepository->persist($orderItem);
        $this->assertTrue($orderItem->getUpdated() instanceof \DateTime);

        $this->orderItemRepository->delete($orderItem);
        $this->assertSame(null, $orderItem->getId());
    }

    public function testFind()
    {
        $this->setupOrderItem();

        $this->setCountLogger();

        $orderItem = $this->orderItemRepository->findOneById(1);

        $orderItem->getProduct()->getCreated();
        $orderItem->getOrder()->getCreated();
        $orderItem->getCatalogPromotions()->toArray();
        $orderItem->getProductQuantityDiscounts()->toArray();
        $orderItem->getOrderItemOptionProducts()->toArray();
        $orderItem->getOrderItemOptionValues()->toArray();
        $orderItem->getOrderItemTextOptionValues()->toArray();

        $this->assertTrue($orderItem instanceof OrderItem);
        $this->assertSame(7, $this->countSQLLogger->getTotalQueries());
    }
}
