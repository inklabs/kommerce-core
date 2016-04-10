<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\UpdateTagCommand;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTagService();
        $tagService->shouldReceive('update')
            ->once();

        $command = new UpdateTagCommand(new TagDTO);
        $handler = new UpdateTagHandler($tagService);
        $handler->handle($command);
    }
}
