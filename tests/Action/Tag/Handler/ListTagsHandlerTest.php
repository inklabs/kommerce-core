<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\ListTagsRequest;
use inklabs\kommerce\Action\Tag\Response\ListTagsResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListTagsHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->getMockeryMock(TagServiceInterface::class);
        $tagService->shouldReceive('getAllTags')
            ->andReturn([
                $this->dummyData->getTag()
            ]);
        /** @var TagServiceInterface $tagService */

        $request = new ListTagsRequest('TT', new PaginationDTO);
        $response = new ListTagsResponse;

        $handler = new ListTagsHandler($tagService, new Pricing);
        $handler->handle($request, $response);

        $this->assertTrue($response->getTagDTOs()[0] instanceof TagDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
