<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageForProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateImageForProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $product = $this->dummyData->getProduct();

        $imageService = $this->mockService->getImageService();
        $imageService->shouldReceive('createImageForProduct')
            ->with($uploadFileDTO, $product->getId())
            ->once();

        $command = new CreateImageForProductCommand(
            $uploadFileDTO,
            $product->getId()
        );

        $handler = new CreateImageForProductHandler($imageService);
        $handler->handle($command);
    }
}
