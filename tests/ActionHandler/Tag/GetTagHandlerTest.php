<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagQuery;
use inklabs\kommerce\Action\Tag\Query\GetTagRequest;
use inklabs\kommerce\Action\Tag\Query\GetTagResponse;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $pricing = $this->dummyData->getPricing();
        $tagService = $this->mockService->getTagService();

        $request = new GetTagRequest(1);
        $response = new GetTagResponse;

        $handler = new GetTagHandler($tagService, $pricing);
        $handler->handle(new GetTagQuery($request, $response));

        $this->assertTrue($response->getTagDTO() instanceof TagDTO);
    }
}
