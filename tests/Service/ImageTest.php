<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
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

    public function testFind()
    {
        $image = $this->imageService->find(1);
        $this->assertTrue($image instanceof View\Image);
    }

    public function testFindMissing()
    {
        $this->imageRepository->setReturnValue(null);

        $image = $this->imageService->find(1);
        $this->assertSame(null, $image);
    }

    public function testEdit()
    {
        $image = $this->getDummyImage();
        $this->assertNotSame(500, $image->getWidth());

        $image->setWidth(500);
        $newImage = $this->imageService->edit($image);
        $this->assertSame(500, $newImage->getWidth());
    }

    public function testCreate()
    {
        $image = $this->getDummyImage();

        $newImage = $this->imageService->create($image);
        $this->assertTrue($newImage instanceof Entity\Image);
    }

    public function testCreateWithProduct()
    {
        $image = $this->getDummyImage();

        $newImage = $this->imageService->createWithProduct($image, 1);
        $this->assertTrue($newImage instanceof Entity\Image);
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
}
