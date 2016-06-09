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
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetTagRequest(self::UUID_HEX);
        $response = new GetTagResponse($pricing);

        $handler = new GetTagHandler($tagService, $dtoBuilderFactory);

        $handler->handle(new GetTagQuery($request, $response));
        $this->assertTrue($response->getTagDTO() instanceof TagDTO);

        $handler->handle(new GetTagQuery($request, $response));
        $this->assertTrue($response->getTagDTOWithAllData() instanceof TagDTO);
    }
}
