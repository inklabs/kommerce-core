<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;

class OrderItemTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Order',
        'kommerce:OrderItem',
        'kommerce:OrderItemOptionValue',
        'kommerce:Product',
        'kommerce:ProductQuantityDiscount',
        'kommerce:CatalogPromotion',
        'kommerce:Tag',
        'kommerce:User',
    ];

    /**
     * @return OrderItem
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:OrderItem');
    }

    public function setupOrder()
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
        $this->entityManager->persist($product);
        $this->entityManager->persist($productQuantityDiscount);
        $this->entityManager->persist($user);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupOrder();

        $this->setCountLogger();

        $orderItem = $this->getRepository()
            ->find(1);

        $orderItem->getProduct()->getCreated();
        $orderItem->getOrder();
        $orderItem->getCatalogPromotions()->toArray();
        $orderItem->getProductQuantityDiscounts()->toArray();
        $orderItem->getOrderItemOptionValues()->toArray();

        $this->assertTrue($orderItem instanceof Entity\OrderItem);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }
}
