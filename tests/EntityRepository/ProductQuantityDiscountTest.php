<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class ProductQuantityDiscountTest extends Helper\DoctrineTestCase
{
    /**
     * @return ProductQuantityDiscount
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:ProductQuantityDiscount');
    }

    private function setupProductWithProductQuantityDiscount()
    {
        $product = $this->getDummyProduct();

        $productQuantityDiscount = $this->getDummyProductQuantityDiscount();
        $productQuantityDiscount->setProduct($product);

        $this->entityManager->persist($product);
        $this->entityManager->persist($productQuantityDiscount);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    private function getDummyProduct()
    {
        $product = new Entity\Product;
        $product->setSku('TST');
        $product->setName('Test Product');
        $product->setDescription('Test product description');
        $product->setUnitPrice(500);
        $product->setQuantity(2);
        $product->setIsInventoryRequired(true);
        $product->setIsPriceVisible(true);
        $product->setIsActive(true);
        $product->setIsVisible(true);
        $product->setIsTaxable(true);
        $product->setIsShippable(true);
        $product->setShippingWeight(16);

        return $product;
    }

    private function getDummyProductQuantityDiscount()
    {
        $productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount->setCustomerGroup(null);
        $productQuantityDiscount->setQuantity(6);
        $productQuantityDiscount->setFlagApplyCatalogPromotions(true);

        return $productQuantityDiscount;
    }

    public function testFind()
    {
        $this->setupProductWithProductQuantityDiscount();

        $this->setCountLogger();

        $productQuantityDiscount = $this->getRepository()
            ->find(1);

        $productQuantityDiscount->getProduct()->getName();

        $this->assertTrue($productQuantityDiscount instanceof Entity\ProductQuantityDiscount);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
