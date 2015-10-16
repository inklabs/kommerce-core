<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;
use inklabs\kommerce\tests\Helper;

class TagServiceTest extends Helper\DoctrineTestCase
{
    /** @var FakeTagRepository */
    protected $tagRepository;

    /** @var TagService */
    protected $tagService;

    public function setUp()
    {
        $this->tagRepository = new FakeTagRepository;
        $this->tagService = new TagService($this->tagRepository);
    }

    public function testCreate()
    {
        $tag = $this->dummyData->getTag();
        $this->tagService->create($tag);
        $this->assertTrue($tag instanceof Tag);
    }

    public function testEdit()
    {
        $newName = 'New Name';
        $tag = $this->dummyData->getTag();
        $this->assertNotSame($newName, $tag->getName());

        $tag->setName($newName);
        $this->tagService->update($tag);
        $this->assertSame($newName, $tag->getName());
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
