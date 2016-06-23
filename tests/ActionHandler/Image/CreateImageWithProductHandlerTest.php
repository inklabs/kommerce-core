<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageWithProductCommand;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateImageWithProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $imageService = $this->mockService->getImageService();
        $imageService->shouldReceive('createFromDTOWithProduct')
            ->once();

        $imageDTO = new ImageDTO;

        $command = new CreateImageWithProductCommand(self::UUID_HEX, $imageDTO);
        $handler = new CreateImageWithProductHandler($imageService);
        $handler->handle($command);
    }
}
