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
    protected $repository;

    /** @var Product */
    protected $service;

    public function setUp()
    {
        $this->repository = new FakeProduct;
        $this->service = new Product($this->repository, new Pricing);
    }

    public function testFind()
    {
        $product = $this->service->find(1);
        $this->assertTrue($product instanceof View\Product);
    }

    public function testFindMissing()
    {
        $this->repository->setReturnValue(null);

        $product = $this->service->find(1);
        $this->assertSame(null, $product);
    }

    public function testEdit()
    {
        $product = $this->getDummyProduct();
        $viewProduct = $product->getView()->export();
        $viewProduct->unitPrice = 500;

        $product = $this->service->edit($viewProduct->id, $viewProduct);
        $this->assertTrue($product instanceof Entity\Product);

        $this->assertSame(500, $product->getUnitPrice());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Product
     */
    public function testEditWithMissingProduct()
    {
        $this->repository->setReturnValue(null);
        $product = $this->service->edit(1, new View\Product(new Entity\Product));
    }

    public function testCreate()
    {
        $product = $this->getDummyProduct();
        $viewProduct = $product->getView()->export();
        $viewProduct->unitPrice = 500;

        $newProduct = $this->service->create($viewProduct);
        $this->assertTrue($newProduct instanceof Entity\Product);
    }

    public function testGetAllProducts()
    {
        $products = $this->service->getAllProducts();
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetRelatedProducts()
    {
        $product = new Entity\Product;
        $product->addTag(new Entity\Tag);

        $productView = $product->getView()
            ->withTags()
            ->export();

        $products = $this->service->getRelatedProducts($productView);
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetProductsByTag()
    {
        $products = $this->service->getProductsByTag(new View\Tag(new Entity\Tag));
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetProductsByIds()
    {
        $products = $this->service->getProductsByIds([1]);
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetAllProductsByIds()
    {
        $products = $this->service->getAllProductsByIds([1]);
        $this->assertTrue($products[0] instanceof View\Product);
    }

    public function testGetRandomProducts()
    {
        $products = $this->service->getRandomProducts(1);
        $this->assertTrue($products[0] instanceof View\Product);
    }
}
