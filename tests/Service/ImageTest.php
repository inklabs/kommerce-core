<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeImage;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProduct;

class ImageTest extends Helper\DoctrineTestCase
{
    /** @var FakeImage */
    protected $imageRepository;

    /** @var FakeProduct */
    private $productRepository;

    /** @var Image */
    protected $imageService;

    public function setUp()
    {
        $this->imageRepository = new FakeImage;
        $this->productRepository = new FakeProduct;
        $this->imageService = new Image($this->imageRepository, $this->productRepository);
    }

    public function testCreate()
    {
        $image = $this->getDummyImage();
        $this->imageService->create($image);
        $this->assertTrue($image instanceof Entity\Image);
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

        $this->imageService->createWithProduct($image, 1);
        $this->assertTrue($image instanceof Entity\Image);
        $this->assertTrue($image->getProduct() instanceof Entity\Product);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Product
     */
    public function testCreateWithProductWithMissingProduct()
    {
        $this->productRepository->setReturnValue(null);

        $image = $this->getDummyImage();
        $this->imageService->createWithProduct($image, 1);
    }

    public function testFind()
    {
        $image = $this->imageService->find(1);
        $this->assertTrue($image instanceof Entity\Image);
    }

    public function testFindMissing()
    {
        $this->imageRepository->setReturnValue(null);

        $image = $this->imageService->find(1);
        $this->assertSame(null, $image);
    }
}
