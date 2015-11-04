<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\GetTagRequest;
use inklabs\kommerce\Action\Tag\Response\GetTagResponse;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Action\Tag\Handler\AbstractTagHandlerTestCase;

class GetTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testExecute()
    {
        $tag = $this->dummyData->getTag();
        $this->fakeTagRepository->create($tag);

        $getTagHandler = new GetTagHandler($this->tagService, $this->pricing);
        $response = new GetTagResponse;
        $getTagHandler->handle(new GetTagRequest($tag->getid()), $response);

        $this->assertTrue($response->getTagDTO() instanceof TagDTO);
    }
}
