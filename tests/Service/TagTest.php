<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\EntityRepository\FakeTag;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class TagTest extends Helper\DoctrineTestCase
{
    /** @var FakeTag */
    protected $tagRepository;

    /** @var Tag */
    protected $tagService;

    public function setUp()
    {
        $this->tagRepository = new FakeTag;
        $this->tagService = new Tag($this->tagRepository, new Pricing);
    }

    public function testFind()
    {
        $tag = $this->tagService->find(1);
        $this->assertTrue($tag instanceof View\Tag);
    }

    public function testFindReturnsNull()
    {
        $this->tagRepository->setReturnValue(null);

        $tag = $this->tagService->find(1);
        $this->assertSame(null, $tag);
    }

    public function testFindSimple()
    {
        $tag = $this->tagService->findSimple(1);
        $this->assertTrue($tag instanceof View\Tag);
    }

    public function testFindSimpleReturnsNull()
    {
        $this->tagRepository->setReturnValue(null);

        $tag = $this->tagService->findSimple(1);
        $this->assertSame(null, $tag);
    }

    public function testEdit()
    {
        $tag = $this->getDummyTag();
        $viewTag = $tag->getView()->export();
        $viewTag->name = 'Test Tag 2';

        $this->assertNotSame('Test Tag 2', $tag->getName());

        $tag = $this->tagService->edit($viewTag->id, $viewTag);
        $this->assertTrue($tag instanceof Entity\Tag);

        $this->assertSame('Test Tag 2', $tag->getName());
    }

    /**
     * @expectedException \LogicException
     * @exceptionMessage Missing Tag
     */
    public function testEditWithMissingTag()
    {
        $this->tagRepository->setReturnValue(null);
        $tag = $this->tagService->edit(1, new View\Tag(new Entity\Tag));
    }

    public function testCreate()
    {
        $tag = $this->getDummyTag();
        $viewTag = $tag->getView()->export();

        $newTag = $this->tagService->create($viewTag);
        $this->assertTrue($newTag instanceof Entity\Tag);
    }

    public function testGetAllTags()
    {
        $tags = $this->tagService->getAllTags();
        $this->assertTrue($tags[0] instanceof View\Tag);
    }

    public function testGetTagsByIds()
    {
        $tags = $this->tagService->getTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof View\Tag);
    }

    public function testAllGetTagsByIds()
    {
        $tags = $this->tagService->getAllTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof View\Tag);
    }
}
