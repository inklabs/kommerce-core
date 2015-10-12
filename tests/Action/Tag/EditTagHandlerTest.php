<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Action\Tag\AbstractTagHandlerTestCase;

class EditTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testHandle()
    {
        $tag = $this->getDummyTag();
        $this->fakeTagRepository->create($tag);

        $editTagHandler = new EditTagHandler($this->tagService);
        $editTagHandler->handle(new EditTagCommand(1, [
            'name' => 'New Name',
            'code' => 'NEW-CODE',
            'description' => 'New Description',
            'isActive' => true,
            'isVisible' => true,
            'sortOrder' => 0,
        ]));

        $newTag = $this->fakeTagRepository->findOneById(1);
        $this->assertTrue($newTag instanceof Tag);
        $this->assertSame('New Name', $newTag->getname());
        $this->assertSame(true, $newTag->isActive());
    }
}
