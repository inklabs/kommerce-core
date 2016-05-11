<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeImageRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class ImageServiceTest extends ServiceTestCase
{
    /** @var FakeImageRepository */
    protected $imageRepository;

    /** @var FakeProductRepository */
    private $productRepository;

    /** @var FakeTagRepository */
    protected $tagRepository;

    /** @var ImageService */
    protected $imageService;

    public function setUp()
    {
        parent::setUp();

        $this->imageRepository = new FakeImageRepository;
        $this->productRepository = new FakeProductRepository;
        $this->tagRepository = new FakeTagRepository;
        $this->imageService = new ImageService(
            $this->imageRepository,
            $this->productRepository,
            $this->tagRepository
        );
    }

    public function testCreate()
    {
        $image = $this->dummyData->getImage();
        $this->imageService->create($image);
        $this->assertTrue($image instanceof Image);
    }

    public function testCreateFromDTOWithTag()
    {
        $tag = $this->dummyData->getTag();
        $this->tagRepository->create($tag);
        $imageDTO = $this->dummyData->getImage()->getDTOBuilder()->build();

        $this->imageService->createFromDTOWithTag($imageDTO, $tag->getid());

        $this->assertTrue($this->imageRepository->findOneById(1) instanceof Image);
    }

    public function testEdit()
    {
        $newWidth = 500;
        $image = $this->dummyData->getImage();
        $this->assertNotSame($newWidth, $image->getWidth());

        $image->setWidth($newWidth);
        $this->imageService->update($image);
        $this->assertSame($newWidth, $image->getWidth());
    }

    public function testCreateWithProduct()
    {
        $image = $this->dummyData->getImage();

        $product = new Product;
        $this->productRepository->create($product);

        $this->imageService->createWithProduct($image, $product->getId());
        $this->assertTrue($image instanceof Image);
        $this->assertTrue($image->getProduct() instanceof Product);
    }

    public function testCreateWithProductThrowsException()
    {
        $this->productRepository->setReturnValue(null);

        $image = $this->dummyData->getImage();

        $this->setExpectedException(
            EntityNotFoundException::class,
            'Product not found'
        );

        $this->imageService->createWithProduct($image, 1);
    }

    public function testFind()
    {
        $this->imageRepository->create(new Image);

        $image = $this->imageService->findOneById(1);
        $this->assertTrue($image instanceof Image);
    }
}
