<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\tests\EntityRepository\FakeImage;
use inklabs\kommerce\tests\EntityRepository\FakeProduct;

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
        $viewImage = $image->getView()->export();
        $viewImage->width = 500;

        $this->assertNotSame(500, $image->getWidth());

        $image = $this->imageService->edit($viewImage->id, $viewImage);
        $this->assertTrue($image instanceof Entity\Image);

        $this->assertSame(500, $image->getWidth());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Image
     */
    public function testEditWithMissingImage()
    {
        $this->imageRepository->setReturnValue(null);
        $image = $this->imageService->edit(1, new View\Image(new Entity\Image));
    }

    public function testCreate()
    {
        $image = $this->getDummyImage();
        $viewImage = $image->getView()->export();

        $newImage = $this->imageService->create($viewImage);
        $this->assertTrue($newImage instanceof Entity\Image);
    }

    public function testCreateWithProduct()
    {
        $image = $this->getDummyImage();
        $viewImage = $image->getView()->export();

        $newImage = $this->imageService->createWithProduct($viewImage, 1);
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
        $viewImage = $image->getView()->export();

        $newImage = $this->imageService->createWithProduct($viewImage, 1);
    }
}
