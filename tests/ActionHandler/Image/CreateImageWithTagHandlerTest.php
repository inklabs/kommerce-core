<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageWithTagCommand;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateImageWithTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $imageService = $this->mockService->getImageService();
        $imageService->shouldReceive('createFromDTOWithTag')
            ->once();

        $imageDTO = new ImageDTO;

        $command = new CreateImageWithTagCommand(self::UUID_HEX, $imageDTO);
        $handler = new CreateImageWithTagHandler($imageService);
        $handler->handle($command);
    }
}
