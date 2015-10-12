<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Action\Tag\AbstractTagHandlerTestCase;

class GetTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testExecute()
    {
        $tag = $this->getDummyTag();
        $this->tagRepository->create($tag);

        $getTagHandler = new GetTagHandler($this->tagService);
        $storedTag = $getTagHandler->handle(new GetTagQuery($tag->getid()));

        $this->assertTrue($storedTag instanceof Tag);
    }
}
