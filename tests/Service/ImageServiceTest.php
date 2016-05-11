<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class ImageServiceTest extends ServiceTestCase
{
    /** @var ImageRepositoryInterface | \Mockery\Mock */
    protected $imageRepository;

    /** @var ProductRepositoryInterface | \Mockery\Mock */
    private $productRepository;

    /** @var TagRepositoryInterface | \Mockery\Mock */
    protected $tagRepository;

    /** @var ImageService */
    protected $imageService;

    public function setUp()
    {
        parent::setUp();

        $this->imageRepository = $this->mockRepository->getImageRepository();
        $this->productRepository = $this->mockRepository->getProductRepository();
        $this->tagRepository = $this->mockRepository->getTagRepository();
        $this->imageService = new ImageService(
            $this->imageRepository,
            $this->productRepository,
            $this->tagRepository
        );
    }

    public function testCreate()
    {
        $image = $this->dummyData->getImage();
        $this->imageRepository->shouldReceive('create')
            ->with($image)
            ->once();

        $this->imageService->create($image);
    }

    public function testUpdate()
    {
        $image = $this->dummyData->getImage();
        $this->imageRepository->shouldReceive('update')
            ->with($image)
            ->once();

        $this->imageService->update($image);
    }

    public function testCreateFromDTOWithTag()
    {
        $imageDTO = $this->dummyData->getImage()->getDTOBuilder()->build();
        $tag = $this->dummyData->getTag();
        $tag->setId(1);

        $this->tagRepository->shouldReceive('findOneById')
            ->with($tag->getId())
            ->andReturn($tag)
            ->once();

        $this->imageRepository->shouldReceive('create')
            ->once();

        $this->imageService->createFromDTOWithTag($imageDTO, $tag->getid());
    }

    public function testCreateWithProduct()
    {
        $image = $this->dummyData->getImage();

        $product = $this->dummyData->getProduct();
        $product->setId(1);

        $this->productRepository->shouldReceive('findOneById')
            ->with($product->getId())
            ->andReturn($product)
            ->once();

        $this->imageRepository->shouldReceive('create')
            ->with($image)
            ->once();

        $this->imageService->createWithProduct($image, $product->getId());
        $this->assertSame($product, $image->getProduct());
    }

    public function testFindOneById()
    {
        $image1 = $this->dummyData->getTag();
        $image1->setId(1);
        $this->imageRepository->shouldReceive('findOneById')
            ->with($image1->getId())
            ->andReturn($image1)
            ->once();

        $image = $this->imageService->findOneById($image1->getId());

        $this->assertSame($image1, $image);
    }
}
