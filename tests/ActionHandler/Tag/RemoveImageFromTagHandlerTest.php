<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\RemoveImageFromTagCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveImageFromTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTagService();
        $tagService->shouldReceive('removeImage')
            ->once();

        $tagId = self::UUID_HEX;
        $imageId = self::UUID_HEX;

        $command = new RemoveImageFromTagCommand($tagId, $imageId);
        $handler = new RemoveImageFromTagHandler($tagService);
        $handler->handle($command);
    }
}
