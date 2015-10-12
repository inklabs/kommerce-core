<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\tests\Helper;

class ProductQuantityDiscountTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:ProductQuantityDiscount',
        'kommerce:Product',
    ];

    /** @var ProductQuantityDiscountRepositoryInterface */
    protected $productQuantityDiscountRepository;

    public function setUp()
    {
        $this->productQuantityDiscountRepository = $this->getRepositoryFactory()
            ->getProductQuantityDiscountRepository();
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

        $productQuantityDiscount = $this->productQuantityDiscountRepository->findOneById(1);

        $productQuantityDiscount->getProduct()->getName();

        $this->assertTrue($productQuantityDiscount instanceof ProductQuantityDiscount);
        $this->assertSame(1, $this->getTotalQueries());
    }
}
