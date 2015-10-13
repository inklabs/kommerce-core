<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Action\Tag\Handler\GetTagHandler;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Action\Tag\Handler\AbstractTagHandlerTestCase;
use inklabs\kommerce\tests\Action\Tag\TestingGetTagResponse;

class GetTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testExecute()
    {
        $tag = $this->getDummyTag();
        $this->fakeTagRepository->create($tag);

        $getTagHandler = new GetTagHandler($this->tagService, $this->pricing);
        $response = new TestingGetTagResponse;
        $getTagHandler->handle(new GetTagRequest($tag->getid()), $response);

        $this->assertTrue($response->getTagDTO() instanceof TagDTO);
    }

    public function testHandleThroughQueryBus()
    {
        $this->setupEntityManager(['kommerce:Tag']);
        $tag = $this->getDummyTag();
        $this->getRepositoryFactory()->getTagRepository()->create($tag);

        $response = new TestingGetTagResponse;
        $this->getQueryBus()->execute(new GetTagRequest($tag->getId()), $response);

        $this->assertTrue($response->getTagDTO() instanceof TagDTO);
    }
}
