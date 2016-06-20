<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagsByIdsQuery;
use inklabs\kommerce\Action\Tag\Query\GetTagsByIdsRequest;
use inklabs\kommerce\Action\Tag\Query\GetTagsByIdsResponse;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetTagsByIdsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tag = $this->dummyData->getTag();

        $tagIds = [
            $tag->getId()->getHex(),
        ];

        $dtoBuilderFactory = $this->getDTOBuilderFactory();
        $tagService = $this->mockService->getTagService();
        $tagService->shouldReceive('getTagsByIds')
            ->with([$tag->getId()])
            ->andReturn([$tag]);

        $request = new GetTagsByIdsRequest($tagIds);
        $response = new GetTagsByIdsResponse();

        $handler = new GetTagsByIdsHandler($tagService, $dtoBuilderFactory);
        $handler->handle(new GetTagsByIdsQuery($request, $response));

        $this->assertTrue($response->getTagDTOs()[0] instanceof TagDTO);
    }
}
