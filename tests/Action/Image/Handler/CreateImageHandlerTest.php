<?php
namespace inklabs\kommerce\Action\Image\Handler;

use inklabs\kommerce\Action\Image\CreateImageCommand;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\Service\ImageServiceInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use Mockery;

class CreateImageHandlerTest extends DoctrineTestCase
{
    public function testHandle()
    {
        $imageService = Mockery::mock(ImageServiceInterface::class);
        $imageService->shouldReceive('createFromDTOWithTag');
        /** @var ImageServiceInterface $imageService */

        $command = new CreateImageCommand(new ImageDTO, 1);
        $handler = new CreateImageHandler($imageService);
        $handler->handle($command);
    }
}
