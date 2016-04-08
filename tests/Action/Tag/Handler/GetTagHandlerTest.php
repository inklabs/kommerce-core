<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\GetTagRequest;
use inklabs\kommerce\Action\Tag\Response\GetTagResponse;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tag = $this->dummyData->getTag();

        $tagService = $this->getMockeryMock(TagServiceInterface::class);
        $tagService->shouldReceive('findOneById')
            ->andReturn(
                $tag
            );
        /** @var TagServiceInterface $tagService */

        $pricing = new Pricing;

        $request = new GetTagRequest($tag->getid());
        $response = new GetTagResponse;
        $handler = new GetTagHandler($tagService, $pricing);
        $handler->handle($request, $response);

        $this->assertTrue($response->getTagDTO() instanceof TagDTO);
    }
}
