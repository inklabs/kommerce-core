<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class ProductTest extends \inklabs\kommerce\tests\Helper\DoctrineTestCase
{
    public function setUp()
    {
        $this->product = new Entity\Product;
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setDescription('Test product description');
        $this->product->setPrice(500);
        $this->product->setQuantity(10);
        $this->product->setIsInventoryRequired(true);
        $this->product->setIsPriceVisible(true);
        $this->product->setIsActive(true);
        $this->product->setIsVisible(true);
        $this->product->setIsTaxable(true);
        $this->product->setIsShippable(true);
        $this->product->setShippingWeight(16);
        $this->product->setRating(null);
        $this->product->setDefaultImage(null);
        $this->product->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->entityManager->persist($this->product);
        $this->entityManager->flush();
    }

    public function testFindMissing()
    {
        $productService = new Product($this->entityManager);
        $product = $productService->find(0);
        $this->assertEquals(null, $product);
    }

    public function testFindNotActive()
    {
        $this->product->setIsActive(false);
        $id = $this->product->getId();

        $productService = new Product($this->entityManager);
        $product = $productService->find($id);

        $this->assertEquals(null, $product);
    }

    public function testFind()
    {
        $id = $this->product->getId();

        $productService = new Product($this->entityManager);
        $product = $productService->find($id);

        $this->assertEquals($this->product, $product);
    }

    private function getDummyProduct($num)
    {
        $product = new Entity\Product;
        $product->setSku('TST' . $num);
        $product->setName('Test Product');
        $product->setDescription('Test product description');
        $product->setPrice(500);
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
        $id = $this->product->getId();
        $productService = new Product($this->entityManager);
        $product = $productService->find($id);

        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);
        $product4 = $this->getDummyProduct(4);
        $product5 = $this->getDummyProduct(5);

        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setIsProductGroup(false);
        $tag->setIsVisible(true);

        $product->addTag($tag);
        $product2->addTag($tag);
        $product3->addTag($tag);
        $product4->addTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->persist($product4);
        $this->entityManager->persist($product5);
        $this->entityManager->flush();

        $relatedProducts = $productService->getRelatedProducts($product);

        $this->assertEquals(3, count($relatedProducts));
        $this->assertTrue(in_array($product2, $relatedProducts));
        $this->assertTrue(in_array($product3, $relatedProducts));
        $this->assertTrue(in_array($product4, $relatedProducts));
    }

    public function setupProductsByTag()
    {
        $this->tag = new Entity\Tag;
        $this->tag->setName('Test Tag');
        $this->tag->setDescription('Test Description');
        $this->tag->setDefaultImage('http://lorempixel.com/400/200/');
        $this->tag->setIsProductGroup(false);
        $this->tag->setSortOrder(0);
        $this->tag->setIsVisible(true);
        $this->tag->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->product1 = $this->getDummyProduct(1);
        $this->product2 = $this->getDummyProduct(2);
        $this->product3 = $this->getDummyProduct(3);

        $this->product1->addTag($this->tag);
        $this->product2->addTag($this->tag);
        $this->product3->addTag($this->tag);

        $this->entityManager->persist($this->tag);
        $this->entityManager->persist($this->product1);
        $this->entityManager->persist($this->product2);
        $this->entityManager->persist($this->product3);
        $this->entityManager->flush();
    }

    public function testGetProductsByTag()
    {
        $this->setupProductsByTag();

        $productService = new Product($this->entityManager);
        $tagProducts = $productService->getProductsByTag($this->tag);

        $expected = [
            $this->product1,
            $this->product2,
            $this->product3,
        ];

        $this->assertEquals($expected, $tagProducts);
    }

    public function testGetProductsByTagPaginated()
    {
        $this->setupProductsByTag();

        $maxResults = 2;
        $page = 1;
        $pagination = new Entity\Pagination($maxResults, $page);

        $productService = new Product($this->entityManager);
        $tagProducts = $productService->getProductsByTag($this->tag, $pagination);

        $expected = [
            $this->product1,
            $this->product2,
        ];

        $this->assertEquals($expected, $tagProducts);
        $this->assertEquals(3, $pagination->getTotal());
    }

    public function testGetProductsByTagPaginatedSecondPage()
    {
        $this->setupProductsByTag();

        $maxResults = 2;
        $page = 2;
        $pagination = new Entity\Pagination($maxResults, $page);

        $productService = new Product($this->entityManager);
        $tagProducts = $productService->getProductsByTag($this->tag, $pagination);

        $expected = [
            $this->product3,
        ];

        $this->assertEquals($expected, $tagProducts);
        $this->assertEquals(3, $pagination->getTotal());
    }
}
