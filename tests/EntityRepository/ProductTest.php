<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class ProductTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Attribute',
        'kommerce:AttributeValue',
        'kommerce:Product',
        'kommerce:ProductQuantityDiscount',
        'kommerce:ProductAttribute',
        'kommerce:Image',
        'kommerce:Tag',
    ];

    /**
     * @return Product
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Product');
    }

    private function setupProduct()
    {
        $product1 = $this->getDummyProduct(1);

        $this->entityManager->persist($product1);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupProduct();

        $this->setCountLogger();

        $product = $this->getRepository()
            ->find(1);

        $product->getImages()->toArray();
        $product->getProductQuantityDiscounts()->toArray();
        $product->getTags()->toArray();
        $product->getProductAttributes()->toArray();

        $this->assertTrue($product instanceof Entity\Product);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetRelatedProducts()
    {
        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);

        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setIsVisible(true);

        $product1->addTag($tag);
        $product2->addTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->getRepository()
            ->getRelatedProducts([$product1]);

        $this->assertSame(1, count($products));
        $this->assertSame(2, $products[0]->getId());
    }

    public function testGetProductsByTag()
    {
        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);

        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);

        $product1->addTag($tag);
        $product2->addTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->getRepository()
            ->getProductsByTag($tag);

        $this->assertSame(2, count($products));
        $this->assertSame(1, $products[0]->getId());
        $this->assertSame(2, $products[1]->getid());
    }

    public function testGetProductsByIds()
    {
        $this->setupProduct();

        $products = $this->getRepository()
            ->getProductsByIds([1]);

        $this->assertSame(1, count($products));
        $this->assertSame(1, $products[0]->getId());
    }

    public function testGetAllProducts()
    {
        $this->setupProduct();

        $products = $this->getRepository()
            ->getAllProducts('#1');

        $this->assertSame(1, $products[0]->getId());
    }

    public function testGetAllProductsByIds()
    {
        $this->setupProduct();

        $products = $this->getRepository()
            ->getAllProductsByIds([1]);

        $this->assertSame(1, $products[0]->getId());
    }

    public function testGetRandomProducts()
    {
        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->getRepository()
            ->getRandomProducts(2);

        $this->assertSame(2, count($products));
    }

    public function testGetProductsByTagPaginated()
    {
        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);

        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);

        $product1->addTag($tag);
        $product2->addTag($tag);
        $product3->addTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $maxResults = 2;
        $page = 1;
        $pagination = new Entity\Pagination($maxResults, $page);

        $products = $this->getRepository()
            ->getProductsByTag($tag, $pagination);

        $this->assertSame(2, count($products));
        $this->assertSame(1, $products[0]->getId());
        $this->assertSame(2, $products[1]->getId());
        $this->assertSame(3, $pagination->getTotal());

        // Page 2
        $maxResults = 2;
        $page = 2;
        $pagination = new Entity\Pagination($maxResults, $page);

        $products = $this->getRepository()
            ->getProductsByTag($tag, $pagination);

        $this->assertSame(1, count($products));
        $this->assertSame(3, $products[0]->getId());
        $this->assertSame(3, $pagination->getTotal());
    }
}
