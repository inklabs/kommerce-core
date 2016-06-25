<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\RemoveOptionFromTagCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveOptionFromTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTagService();
        $tagService->shouldReceive('removeOption')
            ->once();

        $tagId = self::UUID_HEX;
        $imageId = self::UUID_HEX;

        $command = new RemoveOptionFromTagCommand($tagId, $imageId);
        $handler = new RemoveOptionFromTagHandler($tagService);
        $handler->handle($command);
    }
}
