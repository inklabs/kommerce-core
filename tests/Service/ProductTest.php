<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\Lib\BaseConvert;
use inklabs\kommerce\tests\Helper as Helper;

class ProductTest extends Helper\DoctrineTestCase
{
    /* @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\Product */
    protected $mockProductRepository;

    /* @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    public function setUp()
    {
        $this->mockProductRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Product');
        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
    }

    public function testFind()
    {
        $product = new Entity\Product;
        $product->setIsActive(true);

        $this->mockProductRepository
            ->shouldReceive('find')
            ->andReturn($product);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockProductRepository);

        $productService = new Product($this->mockEntityManager, new Pricing);

        $product = $productService->find(1);
        $this->assertTrue($product instanceof View\Product);
    }

    public function testFindMissing()
    {
        $this->mockProductRepository
            ->shouldReceive('find')
            ->andReturn(null);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockProductRepository);

        $productService = new Product($this->mockEntityManager, new Pricing);

        $product = $productService->find(1);
        $this->assertEquals(null, $product);
    }

    public function testFindNotActive()
    {
        $product = new Entity\Product;
        $product->setIsActive(false);

        $this->mockProductRepository
            ->shouldReceive('find')
            ->andReturn($product);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockProductRepository);

        $productService = new Product($this->mockEntityManager, new Pricing);

        $product = $productService->find(1);
        $this->assertEquals(null, $product);
    }

    public function testGetAllProducts()
    {
        $this->mockProductRepository
            ->shouldReceive('getAllProducts')
            ->andReturn([new Entity\Product]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockProductRepository);

        $productService = new Product($this->mockEntityManager, new Pricing);

        $products = $productService->getAllProducts();
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetRelatedProducts()
    {
        $this->mockProductRepository
            ->shouldReceive('getRelatedProductsByIds')
            ->andReturn([new Entity\Product]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockProductRepository);

        $productService = new Product($this->mockEntityManager, new Pricing);

        $product = new Entity\Product;
        $product->addTag(new Entity\Tag);

        $productView = $product->getView()
            ->withTags()
            ->export();

        $products = $productService->getRelatedProducts($productView);
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetProductsByTag()
    {
        $this->mockProductRepository
            ->shouldReceive('getProductsByTagId')
            ->andReturn([new Entity\Product]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockProductRepository);

        $productService = new Product($this->mockEntityManager, new Pricing);

        $products = $productService->getProductsByTag(new Entity\View\Tag(new Entity\Tag));
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetProductsByIds()
    {
        $this->mockProductRepository
            ->shouldReceive('getProductsByIds')
            ->andReturn([new Entity\Product]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockProductRepository);

        $productService = new Product($this->mockEntityManager, new Pricing);

        $products = $productService->getProductsByIds([1]);
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetAllProductsByIds()
    {
        $this->mockProductRepository
            ->shouldReceive('getAllProductsByIds')
            ->andReturn([new Entity\Product]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockProductRepository);

        $productService = new Product($this->mockEntityManager, new Pricing);

        $products = $productService->getAllProductsByIds([1]);
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetRandomProducts()
    {
        $this->mockProductRepository
            ->shouldReceive('getRandomProducts')
            ->andReturn([new Entity\Product]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockProductRepository);

        $productService = new Product($this->mockEntityManager, new Pricing);

        $products = $productService->getRandomProducts(1);
        $this->assertTrue($products[0] instanceof View\Product);
    }
}
