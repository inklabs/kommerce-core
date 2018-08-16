<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class ImageServiceTest extends ServiceTestCase
{
    /** @var ImageRepositoryInterface */
    protected $imageRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var TagRepositoryInterface */
    protected $tagRepository;

    /** @var ImageService */
    protected $imageService;

    /** @var FileManagerInterface */
    private $fileManager;

    protected $metaDataClassNames = [
        Image::class,
        Product::class,
        Tag::class,
    ];

    public function setUp()
    {
        parent::setUp();

        $this->fileManager = $this->getServiceFactory()->getFileManager();
        $this->imageRepository = $this->getRepositoryFactory()->getImageRepository();
        $this->productRepository = $this->getRepositoryFactory()->getProductRepository();
        $this->tagRepository = $this->getRepositoryFactory()->getTagRepository();
        $this->imageService = new ImageService(
            $this->fileManager,
            $this->imageRepository,
            $this->productRepository,
            $this->tagRepository
        );
    }

    public function testCreateImageForProduct()
    {
        // Given
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $product = $this->dummyData->getProduct();
        $this->persistEntityAndFlushClear($product);

        // When
        $this->imageService->createImageForProduct($uploadFileDTO, $product->getId());

        // Then
        $this->entityManager->clear();
        $refreshedProduct = $this->productRepository->findOneById($product->getId());
        $this->assertTrue($refreshedProduct->getImages()[0] instanceof Image);
    }

    public function testCreateImageForTag()
    {
        // Given
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $tag = $this->dummyData->getTag();
        $this->persistEntityAndFlushClear($tag);

        // When
        $this->imageService->createImageForTag($uploadFileDTO, $tag->getId());

        // Then
        $this->entityManager->clear();
        $refreshedTag = $this->tagRepository->findOneById($tag->getId());
        $this->assertTrue($refreshedTag->getImages()[0] instanceof Image);
    }

    public function testFindOneById()
    {
        $image1 = $this->dummyData->getImage();
        $this->persistEntityAndFlushClear($image1);

        $image = $this->imageService->findOneById($image1->getId());

        $this->assertEntitiesEqual($image1, $image);
    }
}
