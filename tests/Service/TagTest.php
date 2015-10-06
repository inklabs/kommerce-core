<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;
use inklabs\kommerce\tests\Helper;

class TagTest extends Helper\DoctrineTestCase
{
    /** @var FakeTagRepository */
    protected $tagRepository;

    /** @var Tag */
    protected $tagService;

    public function setUp()
    {
        $this->tagRepository = new FakeTagRepository;
        $this->tagService = new Tag($this->tagRepository);
    }

    public function testFind()
    {
        $tag = $this->tagService->find(1);
        $this->assertTrue($tag instanceof Entity\Tag);
    }

    public function testFindOneByCode()
    {
        $tag = $this->tagService->findOneByCode('TT1');
        $this->assertTrue($tag instanceof Entity\Tag);
    }

    public function testGetTagAndThrowExceptionIfMissing()
    {
        $tag = $this->tagService->getTagAndThrowExceptionIfMissing(1);
        $this->assertTrue($tag instanceof Entity\Tag);
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
        $this->assertTrue($tag instanceof Entity\Tag);
    }

    public function testGetAllTags()
    {
        $tags = $this->tagService->getAllTags();
        $this->assertTrue($tags[0] instanceof Entity\Tag);
    }

    public function testGetTagsByIds()
    {
        $tags = $this->tagService->getTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof Entity\Tag);
    }

    public function testAllGetTagsByIds()
    {
        $tags = $this->tagService->getAllTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof Entity\Tag);
    }
}
