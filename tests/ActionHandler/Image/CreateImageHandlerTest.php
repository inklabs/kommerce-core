<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageCommand;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateImageHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $imageService = $this->mockService->getImageService();
        $imageService->shouldReceive('createFromDTOWithTag')
            ->once();

        $command = new CreateImageCommand(new ImageDTO, 1);
        $handler = new CreateImageHandler($imageService);
        $handler->handle($command);
    }
}
