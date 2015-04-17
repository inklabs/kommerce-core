<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\tests\Helper;

class OrderItemOptionValueTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:OptionType\AbstractOptionType',
        'kommerce:OptionValue\AbstractOptionValue',
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
     * @return OrderItemOptionValue
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:OrderItemOptionValue');
    }

    public function setupOrder()
    {
        $catalogPromotion = $this->getDummyCatalogPromotion();

        $product = $this->getDummyProduct(1);
        $productQuantityDiscount = $this->getDummyProductQuantityDiscount();
        $productQuantityDiscount->setProduct($product);

        $price = $this->getDummyPrice();
        $price->addCatalogPromotion($catalogPromotion);
        $price->addProductQuantityDiscount($productQuantityDiscount);

        $product2 = $this->getDummyProduct(2);
        $option = $this->getDummyOptionTypeProduct();
        $optionValue = $this->getDummyOptionValueProduct($option, $product2);
        $orderItemOptionValue = $this->getDummyOrderItemOptionValue($optionValue);
        $orderItemOptionValue->setOptionValue($optionValue);

        $orderItem = $this->getDummyOrderItem($product, $price);
        $orderItem->addOrderItemOptionValue($orderItemOptionValue);

        $cartTotal = $this->getDummyCartTotal();

        $user = $this->getDummyUser();
        $order = $this->getDummyOrder($cartTotal, [$orderItem]);
        $order->setUser($user);

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->persist($product);
        $this->entityManager->persist($product2);
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
        $orderItemOptionValue->getOptionValue()->getCreated();

        $this->assertTrue($orderItemOptionValue instanceof Entity\OrderItemOptionValue);
        $this->assertSame(6, $this->countSQLLogger->getTotalQueries());
    }
}
