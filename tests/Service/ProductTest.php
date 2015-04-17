<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\EntityRepository\FakeProduct;

class ProductTest extends Helper\DoctrineTestCase
{
    /** @var FakeProduct */
    protected $productRepository;

    /** @var Product */
    protected $productService;

    public function setUp()
    {
        $this->productRepository = new FakeProduct;
        $this->productService = new Product($this->productRepository, new Pricing);
    }

    public function testFind()
    {
        $product = $this->productService->find(1);
        $this->assertTrue($product instanceof View\Product);
    }

    public function testFindMissing()
    {
        $this->productRepository->setReturnValue(null);

        $product = $this->productService->find(1);
        $this->assertSame(null, $product);
    }

    public function testEdit()
    {
        $product = $this->getDummyProduct();
        $viewProduct = $product->getView()->export();
        $viewProduct->unitPrice = 500;

        $product = $this->productService->edit($viewProduct->id, $viewProduct);
        $this->assertTrue($product instanceof Entity\Product);

        $this->assertSame(500, $product->getUnitPrice());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Product
     */
    public function testEditWithMissingProduct()
    {
        $this->productRepository->setReturnValue(null);
        $product = $this->productService->edit(1, new View\Product(new Entity\Product));
    }

    public function testCreate()
    {
        $product = $this->getDummyProduct();
        $viewProduct = $product->getView()->export();
        $viewProduct->unitPrice = 500;

        $newProduct = $this->productService->create($viewProduct);
        $this->assertTrue($newProduct instanceof Entity\Product);
    }

    public function testGetAllProducts()
    {
        $products = $this->productService->getAllProducts();
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetRelatedProducts()
    {
        $product = new Entity\Product;
        $product->addTag(new Entity\Tag);

        $productView = $product->getView()
            ->withTags()
            ->export();

        $products = $this->productService->getRelatedProducts($productView);
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetProductsByTag()
    {
        $products = $this->productService->getProductsByTag(new View\Tag(new Entity\Tag));
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetProductsByIds()
    {
        $products = $this->productService->getProductsByIds([1]);
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetAllProductsByIds()
    {
        $products = $this->productService->getAllProductsByIds([1]);
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetRandomProducts()
    {
        $products = $this->productService->getRandomProducts(1);
        $this->assertTrue($products[0] instanceof View\Product);
    }
}
