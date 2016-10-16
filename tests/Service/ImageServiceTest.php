<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class ImageServiceTest extends ServiceTestCase
{
    /** @var ImageRepositoryInterface|\Mockery\Mock */
    protected $imageRepository;

    /** @var ProductRepositoryInterface|\Mockery\Mock */
    private $productRepository;

    /** @var TagRepositoryInterface|\Mockery\Mock */
    protected $tagRepository;

    /** @var ImageService */
    protected $imageService;

    /** @var FileManagerInterface|\Mockery\Mock */
    private $fileManager;

    public function setUp()
    {
        parent::setUp();

        $this->fileManager = $this->mockService->getFileManager();
        $this->imageRepository = $this->mockRepository->getImageRepository();
        $this->productRepository = $this->mockRepository->getProductRepository();
        $this->tagRepository = $this->mockRepository->getTagRepository();
        $this->imageService = new ImageService(
            $this->fileManager,
            $this->imageRepository,
            $this->productRepository,
            $this->tagRepository
        );
    }

    public function testCRUD()
    {
        $this->executeServiceCRUD(
            $this->imageService,
            $this->imageRepository,
            $this->dummyData->getImage()
        );
    }

    public function testCreateImageForProduct()
    {
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();

        $managedFile = $this->dummyData->getLocalManagedFile();
        $this->fileManager->shouldReceive('saveFile')
            ->with($uploadFileDTO->getFilePath())
            ->once()
            ->andReturn($managedFile);

        $product = $this->dummyData->getProduct();
        $this->productRepository->shouldReceive('findOneById')
            ->with($product->getId())
            ->andReturn($product)
            ->once();

        $this->imageRepository->shouldReceive('create')
            ->once();

        $this->imageService->createImageForProduct($uploadFileDTO, $product->getId());
    }

    public function testCreateImageForTag()
    {
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();

        $managedFile = $this->dummyData->getLocalManagedFile();
        $this->fileManager->shouldReceive('saveFile')
            ->with($uploadFileDTO->getFilePath())
            ->once()
            ->andReturn($managedFile);

        $tag = $this->dummyData->getProduct();
        $this->tagRepository->shouldReceive('findOneById')
            ->with($tag->getId())
            ->andReturn($tag)
            ->once();

        $this->imageRepository->shouldReceive('create')
            ->once();

        $this->imageService->createImageForTag($uploadFileDTO, $tag->getId());
    }

    public function testFindOneById()
    {
        $image1 = $this->dummyData->getTag();
        $this->imageRepository->shouldReceive('findOneById')
            ->with($image1->getId())
            ->andReturn($image1)
            ->once();

        $image = $this->imageService->findOneById($image1->getId());

        $this->assertEntitiesEqual($image1, $image);
    }
}
