<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\ListTagsRequest;
use inklabs\kommerce\Action\Tag\Response\ListTagsResponse;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Action\Tag\Handler\AbstractTagHandlerTestCase;

class ListTagsHandlerTest extends AbstractTagHandlerTestCase
{
    public function testExecute()
    {
        $tag = $this->getDummyTag();
        $this->fakeTagRepository->create($tag);

        $getTagHandler = new ListTagsHandler($this->tagService, $this->pricing);

        $pagination = new Pagination;
        $response = new ListTagsResponse;
        $getTagHandler->handle(new ListTagsRequest('TT', $pagination), $response);

        $this->assertTrue($response->getTagDTOs()[0] instanceof TagDTO);
    }

    public function testHandleThroughQueryBus()
    {
        $this->setupEntityManager(['kommerce:Tag']);

        $tag = $this->getDummyTag();
        $this->getRepositoryFactory()->getTagRepository()->create($tag);

        $pagination = new Pagination;
        $response = new ListTagsResponse;
        $this->getQueryBus()->execute(new ListTagsRequest('TT', $pagination), $response);

        $this->assertTrue($response->getTagDTOs()[0] instanceof TagDTO);
    }
}
