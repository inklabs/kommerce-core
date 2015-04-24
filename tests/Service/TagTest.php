<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\EntityRepository\FakeTag;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class TagTest extends Helper\DoctrineTestCase
{
    /** @var FakeTag */
    protected $repository;

    /** @var Tag */
    protected $service;

    public function setUp()
    {
        $this->repository = new FakeTag;
        $this->service = new Tag($this->repository, new Pricing);
    }

    public function testFind()
    {
        $tag = $this->service->find(1);
        $this->assertTrue($tag instanceof View\Tag);
    }

    public function testFindReturnsNull()
    {
        $this->repository->setReturnValue(null);

        $tag = $this->service->find(1);
        $this->assertSame(null, $tag);
    }

    public function testFindSimple()
    {
        $tag = $this->service->findSimple(1);
        $this->assertTrue($tag instanceof View\Tag);
    }

    public function testFindSimpleReturnsNull()
    {
        $this->repository->setReturnValue(null);

        $tag = $this->service->findSimple(1);
        $this->assertSame(null, $tag);
    }

    public function testEdit()
    {
        $tag = $this->getDummyTag();
        $viewTag = $tag->getView()->export();
        $viewTag->name = 'Test Tag 2';

        $tag = $this->service->edit($viewTag->id, $viewTag);
        $this->assertTrue($tag instanceof Entity\Tag);

        $this->assertSame('Test Tag 2', $tag->getName());
    }

    /**
     * @expectedException \LogicException
     * @exceptionMessage Missing Tag
     */
    public function testEditWithMissingTag()
    {
        $this->repository->setReturnValue(null);
        $tag = $this->service->edit(1, new View\Tag(new Entity\Tag));
    }

    public function testCreate()
    {
        $tag = $this->getDummyTag();
        $viewTag = $tag->getView()->export();

        $newTag = $this->service->create($viewTag);
        $this->assertTrue($newTag instanceof Entity\Tag);
    }

    public function testGetAllTags()
    {
        $tags = $this->service->getAllTags();
        $this->assertTrue($tags[0] instanceof View\Tag);
    }

    public function testGetTagsByIds()
    {
        $tags = $this->service->getTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof View\Tag);
    }

    public function testAllGetTagsByIds()
    {
        $tags = $this->service->getAllTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof View\Tag);
    }
}
