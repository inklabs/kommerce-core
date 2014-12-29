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
        $this->assertSame(null, $product);
    }

    private function getProduct()
    {
        $product = new Entity\Product;
        $product->setSku('TST1');
        $product->setName('Test Product');
        $product->setDescription('Test product description');
        $product->setUnitPrice(400);
        $product->setQuantity(2);
        $product->setIsInventoryRequired(true);
        $product->setIsPriceVisible(true);
        $product->setIsActive(true);
        $product->setIsVisible(true);
        $product->setIsTaxable(true);
        $product->setIsShippable(true);
        $product->setShippingWeight(16);

        $this->entityManager->persist($product);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $product;
    }

    public function testEdit()
    {
        $product = $this->getProduct();

        $productService = new Product($this->entityManager, new Pricing);

        $productValues = new View\Product($product);
        $productValues->sku = 'TST1';
        $productValues->name = 'Test Product';
        $productValues->description = 'Test product description';
        $productValues->unitPrice = 500;
        $productValues->quantity = 10;
        $productValues->isInventoryRequired = true;
        $productValues->isPriceVisible = true;
        $productValues->isActive = true;
        $productValues->isVisible = true;
        $productValues->isTaxable = true;
        $productValues->isShippable = true;
        $productValues->shippingWeight = 16;

        $productService->edit($product->getId(), $productValues);

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
        $productService->edit(1, new View\Product(new Entity\Product));
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\ValidatorException
     */
    public function testEditFailsValidation()
    {
        $product = $this->getProduct();

        $productService = new Product($this->entityManager, new Pricing);

        $productValues = new View\Product($product);
        $productValues->sku = 'TST1';
        $productValues->name = null;
        $productValues->description = 'Test product description';
        $productValues->unitPrice = -1;
        $productValues->quantity = -1;
        $productValues->isInventoryRequired = true;
        $productValues->isPriceVisible = true;
        $productValues->isActive = true;
        $productValues->isVisible = true;
        $productValues->isTaxable = true;
        $productValues->isShippable = true;
        $productValues->shippingWeight = -1;

        $productService->edit($product->getId(), $productValues);
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
