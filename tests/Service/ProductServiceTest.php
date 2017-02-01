<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class ProductServiceTest extends ServiceTestCase
{
    /** @var ProductRepositoryInterface|\Mockery\Mock */
    protected $productRepository;

    /** @var TagRepositoryInterface|\Mockery\Mock */
    protected $tagRepository;

    /** @var ImageRepositoryInterface|\Mockery\Mock */
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
}
