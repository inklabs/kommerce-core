<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\UpdateTagCommand;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Action\Tag\Handler\AbstractTagHandlerTestCase;

class UpdateTagHandlerTest extends AbstractTagHandlerTestCase
{
    /** @var TagDTO */
    protected $tagDTO;

    public function setUp()
    {
        parent::setUp();

        $this->tagDTO = new TagDTO;
        $this->tagDTO->name = 'New Name';
        $this->tagDTO->code = 'NEW-CODE';
        $this->tagDTO->description = 'New Description';
        $this->tagDTO->isActive = true;
        $this->tagDTO->isVisible = true;
        $this->tagDTO->sortOrder = 0;
    }

    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->fakeTagRepository->create($tag);

        $this->tagDTO->id = $tag->getId();

        $editTagHandler = new UpdateTagHandler($this->tagService);

        $editTagHandler->handle(new UpdateTagCommand($this->tagDTO));

        $newTag = $this->fakeTagRepository->findOneById(1);
        $this->assertTrue($newTag instanceof Tag);
        $this->assertSame('New Name', $newTag->getname());
    }
}
