<?php
namespace inklabs\kommerce\Tests\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\SetDefaultImageForTagCommand;
use inklabs\kommerce\ActionHandler\Tag\SetDefaultImageForTagHandler;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetDefaultImageForTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $imageService = $this->mockService->getImageService();
        $tagService = $this->mockService->getTagService();
        $tagService->shouldReceive('update')
            ->once();

        $command = new SetDefaultImageForTagCommand(self::UUID_HEX, self::UUID_HEX);
        $handler = new SetDefaultImageForTagHandler($tagService, $imageService);
        $handler->handle($command);
    }
}
