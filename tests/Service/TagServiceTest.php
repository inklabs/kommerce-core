<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;
use inklabs\kommerce\tests\Helper;

class TagServiceTest extends Helper\TestCase\ServiceTestCase
{
    /** @var FakeTagRepository */
    protected $tagRepository;

    /** @var TagService */
    protected $tagService;

    public function setUp()
    {
        parent::setUp();
        $this->tagRepository = new FakeTagRepository;
        $this->tagService = new TagService($this->tagRepository);
    }

    public function testCreate()
    {
        $tag = $this->dummyData->getTag();

        $this->tagService->create($tag);

        $tag = $this->tagRepository->findOneById(1);
        $this->assertTrue($tag instanceof Tag);
    }

    public function testUpdate()
    {
        $newName = 'New Name';
        $tag = $this->dummyData->getTag();
        $this->tagRepository->create($tag);

        $this->assertNotSame($newName, $tag->getName());
        $tag->setName($newName);

        $this->tagService->update($tag);

        $tag = $this->tagRepository->findOneById(1);
        $this->assertSame($newName, $tag->getName());
    }

    public function testDelete()
    {
        $tag = $this->dummyData->getTag();
        $this->tagRepository->create($tag);

        $this->tagService->delete($tag);

        $this->setExpectedException(
            EntityNotFoundException::class,
            'Tag not found'
        );
        $this->tagRepository->findOneById(1);
    }

    public function testFind()
    {
        $this->tagRepository->create(new Tag);
        $tag = $this->tagService->findOneById(1);
        $this->assertTrue($tag instanceof Tag);
    }

    public function testFindOneByCode()
    {
        $tag = new Tag;
        $tag->setCode('TT1');
        $this->tagRepository->create($tag);

        $tag = $this->tagService->findOneByCode('TT1');

        $this->assertTrue($tag instanceof Tag);
    }

    public function testGetAllTags()
    {
        $tags = $this->tagService->getAllTags();
        $this->assertTrue($tags[0] instanceof Tag);
    }

    public function testGetTagsByIds()
    {
        $tags = $this->tagService->getTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof Tag);
    }

    public function testAllGetTagsByIds()
    {
        $tags = $this->tagService->getAllTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof Tag);
    }
}
