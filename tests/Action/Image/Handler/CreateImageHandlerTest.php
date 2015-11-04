<?php
namespace inklabs\kommerce\Action\Image\Handler;

use inklabs\kommerce\Action\Image\CreateImageCommand;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\Service\ImageService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeImageRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeProductRepository;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;

class CreateImageHandlerTest extends DoctrineTestCase
{
    /** @var ImageDTO */
    protected $imageDTO;

    /** @var FakeTagRepository */
    protected $fakeTagRepository;

    /** @var FakeImageRepository */
    protected $fakeImageRepository;

    /** @var FakeProductRepository */
    protected $fakeProductRepository;

    /** @var ImageService */
    protected $imageService;

    public function setUp()
    {
        parent::setUp();

        $this->fakeImageRepository = new FakeImageRepository;
        $this->fakeTagRepository = new FakeTagRepository;
        $this->fakeProductRepository = new FakeProductRepository;

        $this->imageService = new ImageService(
            $this->fakeImageRepository,
            $this->fakeProductRepository,
            $this->fakeTagRepository
        );

        $this->imageDTO = new ImageDTO;
        $this->imageDTO->path = 'http://lorempixel.com/400/200/';
        $this->imageDTO->width = 400;
        $this->imageDTO->height = 200;
        $this->imageDTO->sortOrder = 0;
    }

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->fakeTagRepository->create($tag);

        $createImageHandler = new CreateImageHandler($this->imageService);
        $createImageHandler->handle(new CreateImageCommand($this->imageDTO, $tag->getId()));

        $this->assertTrue($this->fakeImageRepository->findOneById(1) instanceof Image);
    }
}
