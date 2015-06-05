<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProduct;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTag;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeImage;

class ProductTest extends Helper\DoctrineTestCase
{
    /** @var FakeProduct */
    protected $productRepository;

    /** @var FakeTag */
    protected $tagRepository;

    /** @var FakeImage */
    protected $imageRepository;

    /** @var Product */
    protected $productService;

    public function setUp()
    {
        $this->productRepository = new FakeProduct;
        $this->tagRepository = new FakeTag;
        $this->imageRepository = new FakeImage;

        $this->productService = new Product(
            $this->productRepository,
            $this->tagRepository,
            $this->imageRepository,
            new Lib\Pricing
        );
    }

    public function testCreate()
    {
        $product = $this->getDummyProduct();
        $this->productService->create($product);
        $this->assertTrue($product instanceof Entity\Product);
    }

    public function testEdit()
    {
        $newName = 'New Name';
        $product = $this->getDummyProduct();
        $this->assertNotSame($newName, $product->getName());

        $product->setName($newName);
        $this->productService->edit($product);
        $this->assertSame($newName, $product->getName());
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

    public function testAddTag()
    {
        $product = new Entity\Product;
        $this->productRepository->setReturnValue($product);

        $productId = 1;
        $tagEncodedId = '1';
        $this->productService->addTag($productId, $tagEncodedId);

        $this->assertTrue($product->getTags()[0] instanceof Entity\Tag);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Product
     */
    public function testAddTagWithMissingProduct()
    {
        $this->productRepository->setReturnValue(null);

        $productId = 1;
        $tagEncodedId = '1';
        $this->productService->addTag($productId, $tagEncodedId);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Tag
     */
    public function testAddTagWithMissingTag()
    {
        $this->tagRepository->setReturnValue(null);

        $productId = 1;
        $tagEncodedId = '1';
        $this->productService->addTag($productId, $tagEncodedId);
    }

    public function testRemoveImage()
    {
        $image = $this->getDummyImage();
        $image->setId(1);

        $product = $this->getDummyProduct();
        $product->setId(1);
        $product->addImage($image);

        $this->productRepository->setReturnValue($product);
        $this->imageRepository->setReturnValue($image);

        $this->productService->removeImage($product->getId(), $image->getId());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Image
     */
    public function testRemoveImageWithMissingImage()
    {
        $this->imageRepository->setReturnValue(null);
        $this->productService->removeImage(1, 1);
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
