<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Action\Tag\Handler\UpdateTagHandler;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Action\Tag\Handler\AbstractTagHandlerTestCase;

class UpdateTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testHandle()
    {
        $tag = $this->getDummyTag();
        $this->fakeTagRepository->create($tag);

        $editTagHandler = new UpdateTagHandler($this->tagService);

        $tagDTO = new TagDTO;
        $tagDTO->id = $tag->getId();
        $tagDTO->name = 'New Name';
        $tagDTO->code = 'NEW-CODE';
        $tagDTO->description = 'New Description';
        $tagDTO->isActive = true;
        $tagDTO->isVisible = true;
        $tagDTO->sortOrder = 0;

        $editTagHandler->handle(new UpdateTagCommand($tagDTO));

        $newTag = $this->fakeTagRepository->findOneById(1);
        $this->assertTrue($this->fakeTagRepository->findOneById(1) instanceof Tag);
        $this->assertSame('New Name', $newTag->getname());
    }
}
