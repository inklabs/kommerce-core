<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\ListTagsQuery;
use inklabs\kommerce\Action\Tag\Query\ListTagsRequest;
use inklabs\kommerce\Action\Tag\Query\ListTagsResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListTagsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $pricing = $this->dummyData->getPricing();
        $tagService = $this->mockService->getTagService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $queryString = 'TT';
        $request = new ListTagsRequest($queryString, new PaginationDTO);
        $response = new ListTagsResponse;

        $handler = new ListTagsHandler($tagService, $dtoBuilderFactory);
        $handler->handle(new ListTagsQuery($request, $response));

        $this->assertTrue($response->getTagDTOs()->current() instanceof TagDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
