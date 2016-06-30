<?php
namespace inklabs\kommerce\Service;

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

    public function testCRUD()
    {
        $this->executeServiceCRUD(
            $this->productService,
            $this->productRepository,
            $this->dummyData->getProduct()
        );
    }

    public function testFindOneById()
    {
        $product1 = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('findOneById')
            ->with($product1->getId())
            ->andReturn($product1)
            ->once();

        $product = $this->productService->findOneById($product1->getId());

        $this->assertEntitiesEqual($product1, $product);
    }

    public function testAddTag()
    {
        $product = $this->dummyData->getProduct();
        $tag1 = $this->dummyData->getTag();

        $this->productRepository->shouldReceive('findOneById')->with($product->getId())->andReturn($product);
        $this->tagRepository->shouldReceive('findOneById')->andReturn($tag1);
        $this->productRepository->shouldReceive('update')->once();

        $this->productService->addTag($product->getId(), $tag1->getId());

        $this->assertEntitiesEqual($tag1, $product->getTags()[0]);
    }

    public function testRemoveTag()
    {
        $tag = $this->dummyData->getTag();
        $product = $this->dummyData->getProduct();
        $product->addTag($tag);

        $this->productRepository->shouldReceive('findOneById')->andReturn($product);
        $this->tagRepository->shouldReceive('findOneById')->andReturn($tag);
        $this->productRepository->shouldReceive('update')->once();

        $this->productService->removeTag($product->getId(), $tag->getId());

        $this->assertCount(0, $product->getTags());
    }

    public function testRemoveImage()
    {
        $image = $this->dummyData->getImage();
        $product = $this->dummyData->getProduct();
        $product->addImage($image);

        $this->imageRepository->shouldReceive('findOneById')->andReturn($image);
        $this->productRepository->shouldReceive('findOneById')->andReturn($product);
        $this->productRepository->shouldReceive('update')->with($product)->once();
        $this->imageRepository->shouldReceive('delete')->with($image)->once();

        $this->productService->removeImage($product->getId(), $image->getId());
    }

    public function testGetAllProducts()
    {
        $product1 = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('getAllProducts')
            ->andReturn([$product1])
            ->once();

        $products = $this->productService->getAllProducts();

        $this->assertEntitiesEqual($product1, $products[0]);
    }

    public function testGetRelatedProducts()
    {
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();
        $tag1 = $this->dummyData->getTag();
        $tag1->addProduct($product1);
        $tag1->addProduct($product2);

        $this->productRepository->shouldReceive('getRelatedProductsByIds')
            ->with([$product1->getId()], [$tag1->getId()], 12)
            ->andReturn([$product2])
            ->once();

        $products = $this->productService->getRelatedProducts($product1);

        $this->assertEntitiesEqual($product2, $products[0]);
    }

    public function testGetRelatedProductsByIds()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('getRelatedProductsByIds')
            ->with([self::UUID_HEX], [], 12)
            ->andReturn([$product])
            ->once();

        $products = $this->productService->getRelatedProductsByIds([self::UUID_HEX]);

        $this->assertEntitiesEqual($product, $products[0]);
    }

    public function testGetProductsByTag()
    {
        $tag = $this->dummyData->getTag();
        $product1 = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('getProductsByTagId')
            ->with($tag->getId(), null)
            ->andReturn([$product1])
            ->once();

        $products = $this->productService->getProductsByTagId($tag->getId());

        $this->assertEntitiesEqual($product1, $products[0]);
    }

    public function testGetProductsByIds()
    {
        $product1 = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('getProductsByIds')
            ->with([$product1->getId()], null)
            ->andReturn([$product1])
            ->once();

        $products = $this->productService->getProductsByIds([
            $product1->getId()
        ]);

        $this->assertEntitiesEqual($product1, $products[0]);
    }

    public function testGetAllProductsByIds()
    {
        $product1 = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('getAllProductsByIds')
            ->with([$product1->getId()], null)
            ->andReturn([$product1])
            ->once();

        $products = $this->productService->getAllProductsByIds([
            $product1->getId()
        ]);

        $this->assertEntitiesEqual($product1, $products[0]);
    }

    public function testGetRandomProducts()
    {
        $limit = 1;
        $product1 = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('getRandomProducts')
            ->with($limit)
            ->andReturn([$product1])
            ->once();

        $products = $this->productService->getRandomProducts($limit);

        $this->assertEntitiesEqual($product1, $products[0]);
    }
}
