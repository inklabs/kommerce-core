<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class ProductServiceTest extends ServiceTestCase
{
    /** @var ProductRepositoryInterface | \Mockery\Mock */
    protected $productRepository;

    /** @var TagRepositoryInterface | \Mockery\Mock */
    protected $tagRepository;

    /** @var ImageRepositoryInterface | \Mockery\Mock */
    protected $imageRepository;

    /** @var ProductService */
    protected $productService;

    public function setUp()
    {
        parent::setUp();

        $this->productRepository = $this->mockRepository->getProductRepository();
        $this->tagRepository = $this->mockRepository->getTagRepository();
        $this->imageRepository = $this->mockRepository->getImageRepository();

        $this->productService = new ProductService(
            $this->productRepository,
            $this->tagRepository,
            $this->imageRepository
        );
    }

    public function testCreate()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('create')
            ->with($product)
            ->once();

        $this->productService->create($product);
    }

    public function testUpdate()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('update')
            ->with($product)
            ->once();

        $this->productService->update($product);
    }

    public function testFindOneById()
    {
        $product1 = $this->dummyData->getTag();
        $product1->setId(1);
        $this->productRepository->shouldReceive('findOneById')
            ->with($product1->getId())
            ->andReturn($product1)
            ->once();

        $product = $this->productService->findOneById($product1->getId());

        $this->assertSame($product1, $product);
    }

    public function testAddTag()
    {
        $product = $this->dummyData->getProduct();
        $tag1 = $this->dummyData->getTag();

        $this->productRepository->shouldReceive('findOneById')
            ->with($product->getId())
            ->andReturn($product);

        $this->tagRepository->shouldReceive('findOneById')
            ->andReturn($tag1);

        $this->productRepository->shouldReceive('update')
            ->once();

        $tag = $this->productService->addTag($product->getId(), $tag1->getId());

        $this->assertSame($tag, $tag1);
        $this->assertSame($tag, $product->getTags()[0]);
    }

    public function testRemoveTag()
    {
        $tag = $this->dummyData->getTag();
        $product = $this->dummyData->getProduct();
        $product->addTag($tag);

        $this->productRepository->shouldReceive('findOneById')
            ->andReturn($product);

        $this->tagRepository->shouldReceive('findOneById')
            ->andReturn($tag);

        $this->productRepository->shouldReceive('update')
            ->once();

        $this->productService->removeTag($product->getId(), $tag->getId());

        $this->assertCount(0, $product->getTags());
    }

    public function testRemoveImage()
    {
        $image = $this->dummyData->getImage();
        $product = $this->dummyData->getProduct();
        $product->addImage($image);

        $this->imageRepository->shouldReceive('findOneById')
            ->andReturn($image);

        $this->productRepository->shouldReceive('findOneById')
            ->andReturn($product);

        $this->productRepository->shouldReceive('update')
            ->with($product)
            ->once();

        $this->imageRepository->shouldReceive('delete')
            ->with($image)
            ->once();

        $this->productService->removeImage($product->getId(), $image->getId());
    }

    public function testGetAllProducts()
    {
        $products = $this->productService->getAllProducts();
        $this->assertTrue($products[0] instanceof Product);
    }

    public function testGetRelatedProducts()
    {
        $product = $this->dummyData->getProduct();
        $products = $this->productService->getRelatedProducts($product);
        $this->assertTrue($products[0] instanceof Product);
    }

    public function testGetProductsByTag()
    {
        $tag = $this->dummyData->getTag();
        $products = $this->productService->getProductsByTagId($tag);
        $this->assertTrue($products[0] instanceof Product);
    }

    public function testGetProductsByIds()
    {
        $products = $this->productService->getProductsByIds([1]);
        $this->assertTrue($products[0] instanceof Product);
    }

    public function testGetAllProductsByIds()
    {
        $products = $this->productService->getAllProductsByIds([1]);
        $this->assertTrue($products[0] instanceof Product);
    }

    public function testGetRandomProducts()
    {
        $products = $this->productService->getRandomProducts(1);
        $this->assertTrue($products[0] instanceof Product);
    }
}
