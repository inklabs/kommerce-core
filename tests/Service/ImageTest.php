<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class ImageTest extends Helper\DoctrineTestCase
{
    /** @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\Image */
    protected $mockImageRepository;

    /** @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    public function setUp()
    {
        $this->mockImageRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Image');
        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockImageRepository);
    }

    public function testFind()
    {
        $image = $this->getDummyImage();

        $this->mockImageRepository
            ->shouldReceive('find')
            ->once()
            ->andReturn($image);

        $imageService = new Image($this->mockEntityManager);

        $image = $imageService->find(1);
        $this->assertTrue($image instanceof View\Image);
    }

    public function testFindMissing()
    {
        $this->mockImageRepository
            ->shouldReceive('find')
            ->once()
            ->andReturn(null);

        $imageService = new Image($this->mockEntityManager);

        $image = $imageService->find(1);
        $this->assertSame(null, $image);
    }

    public function testEdit()
    {
        $image = $this->getDummyImage();
        $viewImage = $image->getView()->export();
        $viewImage->width = 500;

        $this->mockImageRepository
            ->shouldReceive('find')
            ->once()
            ->andReturn($image);

        $this->mockEntityManager
            ->shouldReceive('flush')
            ->once()
            ->andReturnUndefined();

        $imageService = new Image($this->mockEntityManager);
        $image = $imageService->edit($viewImage->id, $viewImage);
        $this->assertTrue($image instanceof Entity\Image);

        $this->assertSame(500, $image->getWidth());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Image
     */
    public function testEditWithMissingImage()
    {
        $this->mockImageRepository
            ->shouldReceive('find')
            ->once()
            ->andReturn(null);

        $imageService = new Image($this->mockEntityManager, new Pricing);
        $image = $imageService->edit(1, new View\Image(new Entity\Image));
    }

    public function testCreate()
    {
        $image = $this->getDummyImage();

        $this->mockEntityManager
            ->shouldReceive('persist')
            ->once()
            ->andReturnUndefined();

        $this->mockEntityManager
            ->shouldReceive('flush')
            ->once()
            ->andReturnUndefined();

        $imageService = new Image($this->mockEntityManager);
        $newImage = $imageService->create($image);
        $this->assertTrue($newImage instanceof Entity\Image);
    }

    public function testCreateWithProduct()
    {
        $image = $this->getDummyImage();
        $product = $this->getDummyProduct();

        $this->mockImageRepository
            ->shouldReceive('find')
            ->andReturn($product);

        $this->mockEntityManager
            ->shouldReceive('persist')
            ->andReturnUndefined();

        $this->mockEntityManager
            ->shouldReceive('flush')
            ->andReturnUndefined();

        $imageService = new Image($this->mockEntityManager);
        $newImage = $imageService->createWithProduct($image, 1);
        $this->assertTrue($newImage instanceof Entity\Image);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Product
     */
    public function testCreateWithProductWithMissingProduct()
    {
        $image = $this->getDummyImage();

        $this->mockImageRepository
            ->shouldReceive('find')
            ->andReturn(null);

        $imageService = new Image($this->mockEntityManager);
        $newImage = $imageService->createWithProduct($image, 1);
    }
}
