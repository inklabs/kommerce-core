<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageForTagCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateImageForTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $tag = $this->dummyData->getTag();

        $imageService = $this->mockService->getImageService();
        $imageService->shouldReceive('createImageForTag')
            ->with($uploadFileDTO, $tag->getId())
            ->once();

        $command = new CreateImageForTagCommand(
            $uploadFileDTO,
            $tag->getId()
        );

        $handler = new CreateImageForTagHandler($imageService);
        $handler->handle($command);
    }
}
