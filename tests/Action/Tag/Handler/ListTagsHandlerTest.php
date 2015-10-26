<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\ListTagsRequest;
use inklabs\kommerce\Action\Tag\Response\ListTagsResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Action\Tag\Handler\AbstractTagHandlerTestCase;

class ListTagsHandlerTest extends AbstractTagHandlerTestCase
{
    public function testHandle()
    {
        $tag = $this->dummyData->getTag();
        $this->fakeTagRepository->create($tag);

        $handler = new ListTagsHandler($this->tagService, $this->pricing);

        $request = new ListTagsRequest('TT', new PaginationDTO);
        $response = new ListTagsResponse;
        $handler->handle($request, $response);

        $this->assertTrue($response->getTagDTOs()[0] instanceof TagDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }

    public function testHandleThroughQueryBus()
    {
        $this->loadDummyTagInRepository();

        $request = new ListTagsRequest('TT', new PaginationDTO);
        $response = new ListTagsResponse;
        $this->getQueryBus()->execute($request, $response);

        $this->assertTrue($response->getTagDTOs()[0] instanceof TagDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }

    private function loadDummyTagInRepository()
    {
        $this->setupEntityManager(['kommerce:Tag']);

        $tag = $this->dummyData->getTag();
        $this->getRepositoryFactory()->getTagRepository()->create($tag);
    }
}
