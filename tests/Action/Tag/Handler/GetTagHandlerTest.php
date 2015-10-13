<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Action\Tag\Handler\GetTagHandler;
use inklabs\kommerce\EntityDTO\TagDTO;
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

    public function testHandleThroughQueryBus()
    {
        $this->setupEntityManager(['kommerce:Tag']);
        $tag = $this->getDummyTag();
        $this->getRepositoryFactory()->getTagRepository()->create($tag);

        /** @var GetTagResponse $response */
        $response = $this->getQueryBus()->execute(new GetTagRequest(1));

        $this->assertTrue($response->getTagDTO() instanceof TagDTO);
    }
}
