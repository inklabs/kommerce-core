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
