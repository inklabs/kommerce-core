<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\DeleteTagCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTagServiceMock();
        $tagService->shouldReceive('delete')
            ->once();

        $command = new DeleteTagCommand(1);
        $handler = new DeleteTagHandler($tagService);
        $handler->handle($command);
    }
}
