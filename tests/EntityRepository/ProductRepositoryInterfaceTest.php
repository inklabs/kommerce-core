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
        $this->productRepository->create(new Product);
        $this->assertTrue($this->productRepository->findOneById(1) instanceof Product);
    }

    public function testFindOneBy()
    {
        $product = new Product;
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
        $this->productRepository->create(new Product);
    }

    public function testSave()
    {
        $this->productRepository->update(new Product);
    }

    public function testDelete()
    {
        $this->productRepository->delete(new Product);
    }

    public function testRemove()
    {
        $this->productRepository->remove(new Product);
    }

    public function testPersist()
    {
        $this->productRepository->persist(new Product);
    }

    public function testFlush()
    {
        $this->productRepository->flush();
    }
}
