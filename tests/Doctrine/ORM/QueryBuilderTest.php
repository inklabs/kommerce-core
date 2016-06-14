<?php
namespace inklabs\kommerce\Doctrine\ORM;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class QueryBuilderTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Product::class,
    ];

    /** @var QueryBuilder */
    private $queryBuilder;

    public function setUp()
    {
        parent::setUp();
        $this->queryBuilder = new QueryBuilder($this->entityManager);
    }

    public function testPaginate()
    {
        $product1 = $this->dummyData->getProduct();

        $this->entityManager->persist($product1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $pagination = $this->dummyData->getPagination();

        $products = $this->queryBuilder
            ->select('Product')
            ->from(Product::class, 'Product')
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        $this->assertEntityInArray($product1, $products);
    }

    public function testSetEntityParameterWithSingleEntity()
    {
        $product1 = $this->dummyData->getProduct();

        $this->entityManager->persist($product1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->queryBuilder
            ->select('Product')
            ->from(Product::class, 'Product')
            ->where('Product.id = :productId')
            ->setEntityParameter('productId', $product1)
            ->getQuery()
            ->getResult();

        $this->assertEntityInArray($product1, $products);
    }

    public function testSetEntityParameterWithMultipleEntities()
    {
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = [
            $product1,
            $product2,
        ];

        $products = $this->queryBuilder
            ->select('Product')
            ->from(Product::class, 'Product')
            ->where('Product.id IN (:productIds)')
            ->setEntityParameter('productIds', $products)
            ->getQuery()
            ->getResult();

        $this->assertEntityInArray($product1, $products);
        $this->assertEntityInArray($product2, $products);
    }
}
