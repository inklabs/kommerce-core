<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class TagServiceTest extends ServiceTestCase
{
    /** @var TagRepositoryInterface | \Mockery\Mock */
    protected $tagRepository;

    /** @var ImageRepositoryInterface | \Mockery\Mock */
    protected $imageRepository;

    /** @var OptionRepositoryInterface | \Mockery\Mock */
    protected $optionRepository;

    /** @var TagService */
    protected $tagService;

    public function setUp()
    {
        parent::setUp();
        $this->tagRepository = $this->mockRepository->getTagRepository();
        $this->imageRepository = $this->mockRepository->getImageRepository();
        $this->optionRepository = $this->mockRepository->getOptionRepository();

        $this->tagService = new TagService(
            $this->tagRepository,
            $this->imageRepository,
            $this->optionRepository
        );
    }

    public function testCRUD()
    {
        $this->executeServiceCRUD(
            $this->tagService,
            $this->tagRepository,
            $this->dummyData->getTag()
        );
    }

    public function testFindOneById()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('findOneById')
            ->with($tag1->getId())
            ->andReturn($tag1)
            ->once();

        $tag = $this->tagService->findOneById($tag1->getId());

        $this->assertEntitiesEqual($tag1, $tag);
    }

    public function testFindOneByCode()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('findOneByCode')
            ->with($tag1->getCode())
            ->andReturn($tag1)
            ->once();

        $tag = $this->tagService->findOneByCode($tag1->getCode());

        $this->assertEntitiesEqual($tag1, $tag);
    }

    public function testGetAllTags()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('getAllTags')
            ->andReturn([$tag1])
            ->once();

        $tags = $this->tagService->getAllTags();

        $this->assertEntitiesEqual($tag1, $tags[0]);
    }

    public function testGetTagsByIds()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('getTagsByIds')
            ->with([$tag1->getId()], null)
            ->andReturn([$tag1])
            ->once();

        $tags = $this->tagService->getTagsByIds([
            $tag1->getId()
        ]);

        $this->assertEntitiesEqual($tag1, $tags[0]);
    }

    public function testAllGetTagsByIds()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('getAllTagsByIds')
            ->with([$tag1->getId()], null)
            ->andReturn([$tag1])
            ->once();

        $tags = $this->tagService->getAllTagsByIds([$tag1->getId()]);

        $this->assertEntitiesEqual($tag1, $tags[0]);
    }

    public function testRemoveImage()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('findOneById')
            ->with($tag1->getId())
            ->andReturn($tag1)
            ->once();

        $image1 = $this->dummyData->getImage();
        $this->imageRepository->shouldReceive('findOneById')
            ->with($image1->getId())
            ->andReturn($image1)
            ->once();

        $this->tagRepository->shouldReceive('update')
            ->once();

        $this->imageRepository->shouldReceive('delete')
            ->with($image1)
            ->once();

        $this->tagService->removeImage($tag1->getId(), $image1->getId());
    }

    public function testAddOption()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('findOneById')
            ->with($tag1->getId())
            ->andReturn($tag1)
            ->once();

        $option1 = $this->dummyData->getOption();
        $this->optionRepository->shouldReceive('findOneById')
            ->with($option1->getId())
            ->andReturn($option1)
            ->once();

        $this->tagRepository->shouldReceive('update')
            ->once();

        $this->tagService->addOption($tag1->getId(), $option1->getId());
    }

    public function testRemoveOption()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('findOneById')
            ->with($tag1->getId())
            ->andReturn($tag1)
            ->once();

        $option1 = $this->dummyData->getOption();
        $this->optionRepository->shouldReceive('findOneById')
            ->with($option1->getId())
            ->andReturn($option1)
            ->once();

        $this->tagRepository->shouldReceive('update')
            ->once();

        $this->tagService->removeOption($tag1->getId(), $option1->getId());
    }
}
