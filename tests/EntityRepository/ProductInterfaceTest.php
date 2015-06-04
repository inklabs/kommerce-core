<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\ProductInterface;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProduct;

class ProductInterfaceTest extends Helper\DoctrineTestCase
{
    /** @var ProductInterface */
    protected $productRepository;

    public function setUp()
    {
        $this->productRepository = new FakeProduct;
    }

    public function testFind()
    {
        $this->assertTrue($this->productRepository->find(1) instanceof Entity\Product);
    }

    public function testFindOneBy()
    {
        $this->assertTrue($this->productRepository->findOneBy(['sku' => 'a']) instanceof Entity\Product);
    }

    public function testGetRelatedProducts()
    {
        $products = [new Entity\Product];
        $this->assertTrue($this->productRepository->getRelatedProducts($products)[0] instanceof Entity\Product);
    }

    public function testGetRelatedProductsByIds()
    {
        $this->assertTrue($this->productRepository->getRelatedProductsByIds([1])[0] instanceof Entity\Product);
    }

    public function testLoadProductTags()
    {
        $products = [new Entity\Product];
        $this->productRepository->loadProductTags($products);
    }

    public function testGetProductsByTag()
    {
        $this->assertTrue($this->productRepository->getProductsByTag(new Entity\Tag)[0] instanceof Entity\Product);
    }

    public function testGetProductsByTagId()
    {
        $this->assertTrue($this->productRepository->getProductsByTagId(1)[0] instanceof Entity\Product);
    }

    public function testGetProductsByIds()
    {
        $productIds = [1];
        $this->assertTrue($this->productRepository->getProductsByIds($productIds)[0] instanceof Entity\Product);
    }

    public function testGetAllProducts()
    {
        $queryString = '';
        $this->assertTrue($this->productRepository->getAllProducts($queryString)[0] instanceof Entity\Product);
    }

    public function testGetAllProductsByIds()
    {
        $productIds = [1];
        $this->assertTrue($this->productRepository->getAllProductsByIds($productIds)[0] instanceof Entity\Product);
    }

    public function testGetRandomProducts()
    {
        $this->assertTrue($this->productRepository->getRandomProducts(10)[0] instanceof Entity\Product);
    }

    public function testCreate()
    {
        $this->productRepository->create(new Entity\Product);
    }

    public function testSave()
    {
        $this->productRepository->save(new Entity\Product);
    }

    public function testRemove()
    {
        $this->productRepository->remove(new Entity\Product);
    }
}
