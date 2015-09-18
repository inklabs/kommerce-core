<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeImageRepository;

class ProductTest extends Helper\DoctrineTestCase
{
    /** @var FakeProductRepository */
    protected $productRepository;

    /** @var FakeTagRepository */
    protected $tagRepository;

    /** @var FakeImageRepository */
    protected $imageRepository;

    /** @var Product */
    protected $productService;

    public function setUp()
    {
        $this->productRepository = new FakeProductRepository;
        $this->tagRepository = new FakeTagRepository;
        $this->imageRepository = new FakeImageRepository;

        $this->productService = new Product(
            $this->productRepository,
            $this->tagRepository,
            $this->imageRepository
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
        $this->assertTrue($product instanceof Entity\Product);
    }

    public function testAddTag()
    {
        $product = new Entity\Product;
        $this->productRepository->setReturnValue($product);

        $productId = 1;
        $tagEncodedId = '1';
        $tag = $this->productService->addTag($productId, $tagEncodedId);

        $this->assertTrue($tag instanceof Entity\Tag);
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

    public function testRemoveTag()
    {
        $tag = $this->getDummyTag();
        $tag->setId(1);

        $product = $this->getDummyProduct();
        $product->setId(1);
        $product->addTag($tag);

        $this->productRepository->setReturnValue($product);
        $this->imageRepository->setReturnValue($tag);

        $this->productService->removeTag($product->getId(), $tag->getId());
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
        $this->assertTrue($products[0] instanceof Entity\Product);
    }

    public function testGetRelatedProducts()
    {
        $product = new Entity\Product;
        $product->addTag(new Entity\Tag);

        $products = $this->productService->getRelatedProducts($product);
        $this->assertTrue($products[0] instanceof Entity\Product);
    }

    public function testGetProductsByTag()
    {
        $products = $this->productService->getProductsByTag(new Entity\Tag);
        $this->assertTrue($products[0] instanceof Entity\Product);
    }

    public function testGetProductsByIds()
    {
        $products = $this->productService->getProductsByIds([1]);
        $this->assertTrue($products[0] instanceof Entity\Product);
    }

    public function testGetAllProductsByIds()
    {
        $products = $this->productService->getAllProductsByIds([1]);
        $this->assertTrue($products[0] instanceof Entity\Product);
    }

    public function testGetRandomProducts()
    {
        $products = $this->productService->getRandomProducts(1);
        $this->assertTrue($products[0] instanceof Entity\Product);
    }
}
