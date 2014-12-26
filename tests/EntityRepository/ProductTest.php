<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib\BaseConvert;
use inklabs\kommerce\tests\Helper as Helper;

class ProductTest extends Helper\DoctrineTestCase
{
    /* @var Entity\Product */
    protected $product;

    /**
     * @return Product
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Product');
    }

    /**
     * @return Entity\Product
     */
    private function getDummyProduct($num)
    {
        $product = new Entity\Product;
        $product->setSku('TST' . $num);
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
            ->getRelatedProducts($product1);

        $this->assertEquals(1, count($products));
        $this->assertEquals(2, $products[0]->getId());
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

        $this->assertEquals(2, count($products));
        $this->assertEquals(1, $products[0]->getId());
        $this->assertEquals(2, $products[1]->getid());
    }

    public function testGetProductsByIds()
    {
        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->getRepository()
            ->getProductsByIds([1]);

        $this->assertEquals(1, count($products));
        $this->assertEquals(1, $products[0]->getId());
    }

    public function testGetAllProducts()
    {
        $product1 = $this->getDummyProduct(1);

        $this->entityManager->persist($product1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->getRepository()
            ->getAllProducts('TST1');

        $this->assertEquals(1, $products[0]->getId());
    }

    public function testGetAllProductsByIds()
    {
        $product1 = $this->getDummyProduct(1);

        $this->entityManager->persist($product1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->getRepository()
            ->getAllProductsByIds([1]);

        $this->assertEquals(1, $products[0]->getId());
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

        $this->assertEquals(2, count($products));
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

        $this->assertEquals(2, count($products));
        $this->assertEquals(1, $products[0]->getId());
        $this->assertEquals(2, $products[1]->getId());
        $this->assertEquals(3, $pagination->getTotal());

        // Page 2
        $maxResults = 2;
        $page = 2;
        $pagination = new Entity\Pagination($maxResults, $page);

        $products = $this->getRepository()
            ->getProductsByTag($tag, $pagination);

        $this->assertEquals(1, count($products));
        $this->assertEquals(3, $products[0]->getId());
        $this->assertEquals(3, $pagination->getTotal());
    }
}
