<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;
use inklabs\kommerce\tests\Helper as Helper;

class OrderItemOptionValueTest extends Helper\DoctrineTestCase
{
    /**
     * @return OrderItemOptionValue
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:OrderItemOptionValue');
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

        $option = $this->getDummyOption();
        $optionValue = $this->getDummyOptionValue($option);
        $orderItemOptionValue = $this->getDummyOrderItemOptionValue($option);
        $orderItemOptionValue->setOptionValue($optionValue);

        $orderItem = $this->getDummyOrderItem($product, $price);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);

        $cartTotal = $this->getDummyCartTotal();

        $user = $this->getDummyUser();
        $order = $this->getDummyOrder($cartTotal, [$orderItem]);
        $order->setUser($user);

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->persist($product);
        $this->entityManager->persist($productQuantityDiscount);
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

        $orderItemOptionValue = $this->getRepository()
            ->find(1);

        $orderItemOptionValue->getOrderItem()->getCreated();
        $orderItemOptionValue->getOption()->getCreated();
        $orderItemOptionValue->getOptionValue()->getCreated();

        $this->assertTrue($orderItemOptionValue instanceof Entity\OrderItemOptionValue);
        $this->assertSame(3, $this->countSQLLogger->getTotalQueries());
    }
}
