<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\tests\Action\Tag\AbstractTagHandlerTestCase;

class EditTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testDispatch()
    {
        $tag = $this->getDummyTag();
        $tag->setName('New Name');
        $this->tagRepository->create($tag);
        $this->assertNull($tag->getUpdated());

        $editTagHandler = new EditTagHandler($this->tagService);
        $editTagHandler->handle(new EditTagCommand($tag));

        $storedTag = $this->tagRepository->findOneById(1);
        $this->assertNotNull($storedTag->getUpdated());
    }
}
