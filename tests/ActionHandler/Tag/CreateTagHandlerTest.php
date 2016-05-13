<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\CreateTagCommand;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTagService();
        $tagService->shouldReceive('create')
            ->once();

        $command = new CreateTagCommand(new TagDTO);
        $handler = new CreateTagHandler($tagService);
        $handler->handle($command);
    }
}
