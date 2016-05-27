<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class ProductRepositoryInterfaceTest extends EntityRepositoryTestCase
{
    /** @var ProductRepositoryInterface */
    protected $productRepository;

    public function setUp()
    {
        parent::setUp();
        $this->productRepository = new FakeProductRepository;
    }

    public function testFind()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->create($product);
        $this->assertTrue($this->productRepository->findOneById(1) instanceof Product);
    }

    public function testFindOneBy()
    {
        $product = $this->dummyData->getProduct();
        $product->setSku('a');
        $this->productRepository->create($product);

        $this->assertTrue($this->productRepository->findOneBySku('a') instanceof Product);
    }

    public function testGetRelatedProducts()
    {
        $products = [new Product];
        $this->assertTrue($this->productRepository->getRelatedProducts($products)[0] instanceof Product);
    }

    public function testGetRelatedProductsByIds()
    {
        $this->assertTrue($this->productRepository->getRelatedProductsByIds([1])[0] instanceof Product);
    }

    public function testLoadProductTags()
    {
        $products = [new Product];
        $this->productRepository->loadProductTags($products);
    }

    public function testGetProductsByTag()
    {
        $this->assertTrue($this->productRepository->getProductsByTag(new Tag)[0] instanceof Product);
    }

    public function testGetProductsByTagId()
    {
        $this->assertTrue($this->productRepository->getProductsByTagId(1)[0] instanceof Product);
    }

    public function testGetProductsByIds()
    {
        $productIds = [1];
        $this->assertTrue($this->productRepository->getProductsByIds($productIds)[0] instanceof Product);
    }

    public function testGetAllProducts()
    {
        $queryString = '';
        $this->assertTrue($this->productRepository->getAllProducts($queryString)[0] instanceof Product);
    }

    public function testGetAllProductsByIds()
    {
        $productIds = [1];
        $this->assertTrue($this->productRepository->getAllProductsByIds($productIds)[0] instanceof Product);
    }

    public function testGetRandomProducts()
    {
        $this->assertTrue($this->productRepository->getRandomProducts(10)[0] instanceof Product);
    }

    public function testGetQueryBuilder()
    {
        $this->productRepository->getQueryBuilder();
    }

    public function testCreate()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->create($product);
    }

    public function testSave()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->update($product);
    }

    public function testDelete()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->delete($product);
    }

    public function testRemove()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->remove($product);
    }

    public function testPersist()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->persist($product);
    }

    public function testFlush()
    {
        $this->productRepository->flush();
    }
}
