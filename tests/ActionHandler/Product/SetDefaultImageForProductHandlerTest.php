<?php
namespace inklabs\kommerce\Tests\ActionHandler\Product;

use inklabs\kommerce\Action\Product\SetDefaultImageForProductCommand;
use inklabs\kommerce\ActionHandler\Product\SetDefaultImageForProductHandler;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetDefaultImageForProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $imageService = $this->mockService->getImageService();
        $productService = $this->mockService->getProductService();
        $productService->shouldReceive('update')
            ->once();

        $command = new SetDefaultImageForProductCommand(self::UUID_HEX, self::UUID_HEX);
        $handler = new SetDefaultImageForProductHandler($productService, $imageService);
        $handler->handle($command);
    }
}
