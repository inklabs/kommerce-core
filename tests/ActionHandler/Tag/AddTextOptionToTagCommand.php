<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\AddTextOptionToTagCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddTextOptionToTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTagService();
        $tagService->shouldReceive('addTextOption')
            ->once();

        $tagId = self::UUID_HEX;
        $imageId = self::UUID_HEX;

        $command = new AddTextOptionToTagCommand($tagId, $imageId);
        $handler = new AddTextOptionToTagHandler($tagService);
        $handler->handle($command);
    }
}
