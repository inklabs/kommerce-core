<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;
use inklabs\kommerce\tests\Helper as Helper;

class OrderItemTest extends Helper\DoctrineTestCase
{
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

        $order = $this->getDummyOrder([$orderItem], $cartTotal);
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
        $orderItem->getOptionProducts()->toArray();

        $this->assertTrue($orderItem instanceof Entity\OrderItem);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }
}
