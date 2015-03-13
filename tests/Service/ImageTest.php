<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\tests\Helper as Helper;

class ImageTest extends Helper\DoctrineTestCase
{
    /* @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\Image */
    protected $mockImageRepository;

    /* @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    public function setUp()
    {
        $this->mockImageRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Image');
        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
    }

    private function setupImage()
    {
        $image = $this->getDummyImage();

        $this->entityManager->persist($image);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $image;
    }

    private function getDummyImage()
    {
        $image = new Entity\Image;
        $image->setId(1);
        $image->setPath('http://lorempixel.com/400/200/');
        $image->setWidth(400);
        $image->setHeight(200);
        $image->setSortOrder(0);

        return $image;
    }

    public function testFind()
    {
        $image = $this->getDummyImage();

        $this->mockImageRepository
            ->shouldReceive('find')
            ->andReturn($image);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockImageRepository);

        $imageService = new Image($this->mockEntityManager);

        $image = $imageService->find(1);
        $this->assertTrue($image instanceof View\Image);
    }

    public function testFindMissing()
    {
        $this->mockImageRepository
            ->shouldReceive('find')
            ->andReturn(null);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockImageRepository);

        $imageService = new Image($this->mockEntityManager);

        $image = $imageService->find(1);
        $this->assertSame(null, $image);
    }

    public function testEdit()
    {
        $imageValues = $this->setupImage()->getView()->export();
        $imageValues->width = 500;

        $imageService = new Image($this->entityManager);
        $image = $imageService->edit($imageValues->id, $imageValues);
        $this->assertTrue($image instanceof Entity\Image);

        $this->entityManager->clear();

        $image = $this->entityManager->find('kommerce:Image', 1);
        $this->assertSame(500, $image->getWidth());
        $this->assertNotSame($imageValues->updated, $image->getUpdated());
    }

    /**
     * @expectedException \LogicException
     */
    public function testEditWithMissingImage()
    {
        $imageService = new Image($this->entityManager, new Pricing);
        $image = $imageService->edit(1, new View\Image(new Entity\Image));
    }

    public function testCreate()
    {
        $image = $this->setupImage();

        $imageService = new Image($this->entityManager);
        $newImage = $imageService->create($image);
        $this->assertTrue($newImage instanceof Entity\Image);

        $this->entityManager->clear();

        $image = $this->entityManager->find('kommerce:Image', 1);
        $this->assertTrue($image instanceof Entity\Image);
    }

    public function testCreateWithProduct()
    {
        $image = $this->setupImage();

        $product = new Entity\Product;
        $product->setName('test');
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $imageService = new Image($this->entityManager);
        $newImage = $imageService->createWithProduct($image, 1);
        $this->assertTrue($newImage instanceof Entity\Image);

        $this->entityManager->clear();

        $image = $this->entityManager->find('kommerce:Image', 1);
        $this->assertTrue($image instanceof Entity\Image);
    }

    /**
     * @expectedException \LogicException
     */
    public function testCreateWithProductWithMissingProduct()
    {
        $image = $this->setupImage();

        $imageService = new Image($this->entityManager);
        $newImage = $imageService->createWithProduct($image, 1);
    }
}
