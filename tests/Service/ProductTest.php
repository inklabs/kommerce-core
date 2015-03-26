<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\tests\Helper as Helper;

class ProductTest extends Helper\DoctrineTestCase
{
    /** @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\Product */
    protected $mockProductRepository;

    /** @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    public function setUp()
    {
        $this->mockProductRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Product');
        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
    }

    private function setupProduct()
    {
        $product = $this->getDummyProduct();

        $this->entityManager->persist($product);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $product;
    }

    public function testFind()
    {
        $product = $this->getDummyProduct();

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
        $this->assertSame(null, $product);
    }

    public function testEdit()
    {
        $productValues = $this->setupProduct()->getView()->export();
        $productValues->unitPrice = 500;

        $productService = new Product($this->entityManager, new Pricing);
        $product = $productService->edit($productValues->id, $productValues);
        $this->assertTrue($product instanceof Entity\Product);

        $this->entityManager->clear();

        $product = $this->entityManager->find('kommerce:Product', 1);
        $this->assertSame(500, $product->getUnitPrice());
        $this->assertNotSame($productValues->updated, $product->getUpdated());
    }

    /**
     * @expectedException \LogicException
     */
    public function testEditWithMissingProduct()
    {
        $productService = new Product($this->entityManager, new Pricing);
        $product = $productService->edit(1, new View\Product(new Entity\Product));
    }

    public function testCreate()
    {
        $productValues = $this->setupProduct()->getView()->export();

        $productService = new Product($this->entityManager, new Pricing);
        $product = $productService->create($productValues);
        $this->assertTrue($product instanceof Entity\Product);

        $this->entityManager->clear();

        $product = $this->entityManager->find('kommerce:Product', 1);
        $this->assertTrue($product instanceof Entity\Product);
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
