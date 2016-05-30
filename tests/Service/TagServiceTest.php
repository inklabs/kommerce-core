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

        $this->assertEqualEntities($tag1, $tag);
    }

    public function testFindOneByCode()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('findOneByCode')
            ->with($tag1->getCode())
            ->andReturn($tag1)
            ->once();

        $tag = $this->tagService->findOneByCode($tag1->getCode());

        $this->assertEqualEntities($tag1, $tag);
    }

    public function testGetAllTags()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('getAllTags')
            ->andReturn([$tag1])
            ->once();

        $tags = $this->tagService->getAllTags();

        $this->assertEqualEntities($tag1, $tags[0]);
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

        $this->assertEqualEntities($tag1, $tags[0]);
    }

    public function testAllGetTagsByIds()
    {
        $tag1 = $this->dummyData->getTag();
        $this->tagRepository->shouldReceive('getAllTagsByIds')
            ->with([$tag1->getId()], null)
            ->andReturn([$tag1])
            ->once();

        $tags = $this->tagService->getAllTagsByIds([$tag1->getId()]);

        $this->assertEqualEntities($tag1, $tags[0]);
    }
}
