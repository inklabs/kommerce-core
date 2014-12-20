<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib\BaseConvert;
use inklabs\kommerce\tests\Helper as Helper;

class ProductTest extends Helper\DoctrineTestCase
{
    /* @var Product */
    protected $productService;

    /* @var Entity\Product */
    protected $product;

    public function setUp()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));
        $this->productService = new Product($this->entityManager, $pricing);
    }

    public function setupProduct()
    {
        $this->product = new Entity\Product;
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setDescription('Test product description');
        $this->product->setUnitPrice(1000);
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

        $this->entityManager->persist($this->product);
        $this->entityManager->flush();
    }

    public function testFindMissing()
    {
        $product = $this->productService->find(0);
        $this->assertEquals(null, $product);
    }

    public function testFindNotActive()
    {
        $this->setupProduct();
        $this->product->setIsActive(false);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $product = $this->productService->find(1);
        $this->assertEquals(null, $product);
    }

    public function testFind()
    {
        $this->setupProduct();

        $this->entityManager->clear();

        $product = $this->productService->find(1);
        $this->assertEquals(1, $product->id);
    }

    public function testFindByEncodedId()
    {
        $this->setupProduct();

        $this->entityManager->clear();

        $product = $this->productService->findByEncodedId(BaseConvert::encode(1));
        $this->assertEquals(1, $product->id);
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
        $this->setupProduct();

        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);

        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setIsVisible(true);

        $this->product->addTag($tag);
        $product1->addTag($tag);
        $product2->addTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $viewProduct = $this->product->getView()
            ->withTags()
            ->export();

        $products = $this->productService->getRelatedProducts($viewProduct);
        $this->assertEquals(2, count($products));
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
        $product3->addTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $viewTag = $tag->getView()
            ->export();

        $products = $this->productService->getProductsByTag($viewTag);

        $this->assertEquals(3, count($products));
        $this->assertEquals(1, $products[0]->id);
        $this->assertEquals(2, $products[1]->id);
        $this->assertEquals(3, $products[2]->id);
    }

    public function testGetProductsByIds()
    {
        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);
        $product4 = $this->getDummyProduct(4);
        $product5 = $this->getDummyProduct(5);

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->persist($product4);
        $this->entityManager->persist($product5);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $productIds = [
            $product2->getId(),
            $product3->getId(),
            $product4->getId(),
        ];

        $products = $this->productService->getProductsByIds($productIds);

        $this->assertEquals(3, count($products));
        $this->assertEquals(2, $products[0]->id);
        $this->assertEquals(3, $products[1]->id);
        $this->assertEquals(4, $products[2]->id);
    }

    public function testGetRandomProducts()
    {
        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);
        $product4 = $this->getDummyProduct(4);
        $product5 = $this->getDummyProduct(5);

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->persist($product4);
        $this->entityManager->persist($product5);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->productService->getRandomProducts(3);

        $this->assertEquals(3, count($products));
    }
}
