<?php
namespace inklabs\kommerce\Tests\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\UnsetDefaultImageForTagCommand;
use inklabs\kommerce\ActionHandler\Tag\UnsetDefaultImageForTagHandler;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UnsetDefaultImageForTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $imageService = $this->mockService->getImageService();
        $tagService = $this->mockService->getTagService();
        $tagService->shouldReceive('update')
            ->once();

        $command = new UnsetDefaultImageForTagCommand(self::UUID_HEX);
        $handler = new UnsetDefaultImageForTagHandler($tagService, $imageService);
        $handler->handle($command);
    }
}
