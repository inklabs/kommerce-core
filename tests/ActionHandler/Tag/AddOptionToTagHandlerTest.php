<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\AddOptionToTagCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddOptionToTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getTagService();
        $tagService->shouldReceive('addOption')
            ->once();

        $tagId = self::UUID_HEX;
        $imageId = self::UUID_HEX;

        $command = new AddOptionToTagCommand($tagId, $imageId);
        $handler = new AddOptionToTagHandler($tagService);
        $handler->handle($command);
    }
}
