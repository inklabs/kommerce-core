<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class TagServiceTest extends ServiceTestCase
{
    /** @var TagRepositoryInterface | \Mockery\Mock */
    protected $tagRepository;

    /** @var TagService */
    protected $tagService;

    public function setUp()
    {
        parent::setUp();
        $this->tagRepository = $this->mockRepository->getTagRepository();
        $this->tagService = new TagService($this->tagRepository);
    }

    public function testCreate()
    {
        $tag = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('create')
            ->with($tag)
            ->once();

        $this->tagService->create($tag);
    }

    public function testUpdate()
    {
        $tag = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('update')
            ->with($tag)
            ->once();

        $this->tagService->update($tag);
    }

    public function testDelete()
    {
        $tag = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('delete')
            ->with($tag)
            ->once();

        $this->tagService->delete($tag);
    }

    public function testFindOneById()
    {
        $tag1 = $this->dummyData->getTag();
        $tag1->setId(1);
        $this->tagRepository->shouldReceive('findOneById')
            ->with($tag1->getId())
            ->andReturn($tag1)
            ->once();

        $tag = $this->tagService->findOneById($tag1->getId());

        $this->assertSame($tag1, $tag);
    }

    public function testFindOneByCode()
    {
        $tag1 = $this->dummyData->getTag();
        $tag1->setId(1);
        $this->tagRepository->shouldReceive('findOneByCode')
            ->with($tag1->getCode())
            ->andReturn($tag1)
            ->once();

        $tag = $this->tagService->findOneByCode($tag1->getCode());

        $this->assertSame($tag1, $tag);
    }

    public function testGetAllTags()
    {
        $tag = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('getAllTags')
            ->andReturn([$tag])
            ->once();

        $tags = $this->tagService->getAllTags();

        $this->assertSame($tag, $tags[0]);
    }

    public function testGetTagsByIds()
    {
        $tag = $this->dummyData->getTag();
        $tag->setId(1);
        $this->tagRepository->shouldReceive('getTagsByIds')
            ->andReturn([$tag])
            ->once();

        $tags = $this->tagService->getTagsByIds([$tag->getId()]);

        $this->assertSame($tag, $tags[0]);
    }

    public function testAllGetTagsByIds()
    {
        $tag = $this->dummyData->getTag();
        $tag->setId(1);
        $this->tagRepository->shouldReceive('getAllTagsByIds')
            ->andReturn([$tag])
            ->once();

        $tags = $this->tagService->getAllTagsByIds([$tag->getId()]);

        $this->assertSame($tag, $tags[0]);
    }
}
