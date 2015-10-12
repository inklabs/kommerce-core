<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\tests\Action\Tag\AbstractTagHandlerTestCase;

class GetTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testExecute()
    {
        $tag = $this->getDummyTag();
        $this->fakeTagRepository->create($tag);

        $getTagHandler = new GetTagHandler($this->tagService, $this->pricing);
        $storedTag = $getTagHandler->handle(new GetTagRequest($tag->getid()));

        $this->assertTrue($storedTag instanceof GetTagResponse);
    }
}
