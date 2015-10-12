<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Action\Tag\Handler\GetTagHandler;
use inklabs\kommerce\tests\Action\Tag\Handler\AbstractTagHandlerTestCase;

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
