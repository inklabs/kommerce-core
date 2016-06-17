<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\CreateTagCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTagService();
        $tagService->shouldReceive('create')
            ->once();

        $tagDTO = $this->getDTOBuilderFactory()
            ->getTagDTOBuilder($this->dummyData->getTag())
            ->build();

        $command = new CreateTagCommand($tagDTO);
        $handler = new CreateTagHandler($tagService);
        $handler->handle($command);
    }
}
