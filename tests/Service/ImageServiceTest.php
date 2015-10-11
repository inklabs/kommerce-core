<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeImageRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;

class ImageServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeImageRepository */
    protected $imageRepository;

    /** @var FakeProductRepository */
    private $productRepository;

    /** @var ImageService */
    protected $imageService;

    public function setUp()
    {
        $this->imageRepository = new FakeImageRepository;
        $this->productRepository = new FakeProductRepository;
        $this->imageService = new ImageService($this->imageRepository, $this->productRepository);
    }

    public function testCreate()
    {
        $image = $this->getDummyImage();
        $this->imageService->create($image);
        $this->assertTrue($image instanceof Image);
    }

    public function testEdit()
    {
        $newWidth = 500;
        $image = $this->getDummyImage();
        $this->assertNotSame($newWidth, $image->getWidth());

        $image->setWidth($newWidth);
        $this->imageService->edit($image);
        $this->assertSame($newWidth, $image->getWidth());
    }

    public function testCreateWithProduct()
    {
        $image = $this->getDummyImage();

        $product = new Product;
        $this->productRepository->create($product);

        $this->imageService->createWithProduct($image, $product->getId());
        $this->assertTrue($image instanceof Image);
        $this->assertTrue($image->getProduct() instanceof Product);
    }

    /**
     * @expectedException \inklabs\kommerce\EntityRepository\EntityNotFoundException
     * @expectedExceptionMessage Product not found
     */
    public function testCreateWithProductThrowsException()
    {
        $this->productRepository->setReturnValue(null);

        $image = $this->getDummyImage();
        $this->imageService->createWithProduct($image, 1);
    }

    public function testFind()
    {
        $this->imageRepository->create(new Image);

        $image = $this->imageService->findOneById(1);
        $this->assertTrue($image instanceof Image);
    }
}
