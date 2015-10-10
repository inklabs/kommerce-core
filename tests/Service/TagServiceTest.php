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
        $tag = $this->getDummyTag();
        $this->tagService->create($tag);
        $this->assertTrue($tag instanceof Tag);
    }

    public function testEdit()
    {
        $newName = 'New Name';
        $tag = $this->getDummyTag();
        $this->assertNotSame($newName, $tag->getName());

        $tag->setName($newName);
        $this->tagService->edit($tag);
        $this->assertSame($newName, $tag->getName());
    }

    public function testFind()
    {
        $tag = $this->tagService->findById(1);
        $this->assertTrue($tag instanceof Tag);
    }

    public function testFindOneByCode()
    {
        $tag = $this->tagService->findOneByCode('TT1');
        $this->assertTrue($tag instanceof Tag);
    }

    public function testGetTagAndThrowExceptionIfMissing()
    {
        $tag = $this->tagService->getTagAndThrowExceptionIfMissing(1);
        $this->assertTrue($tag instanceof Tag);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Tag
     */
    public function testGetTagAndThrowExceptionIfMissingThrows()
    {
        $this->tagRepository->setReturnValue(null);
        $this->tagService->getTagAndThrowExceptionIfMissing(1);
    }

    public function testFindSimple()
    {
        $tag = $this->tagService->findSimple(1);
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
