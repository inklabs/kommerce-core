<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\GetTagRequest;
use inklabs\kommerce\Action\Tag\Response\GetTagResponse;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $pricing = $this->dummyData->getPricing();
        $tagService = $this->mockService->getTagServiceMock();

        $request = new GetTagRequest(1);
        $response = new GetTagResponse;

        $handler = new GetTagHandler($tagService, $pricing);
        $handler->handle($request, $response);

        $this->assertTrue($response->getTagDTO() instanceof TagDTO);
    }
}
