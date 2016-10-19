<?php
namespace inklabs\kommerce\Tests\ActionHandler\Product;

use inklabs\kommerce\Action\Product\UnsetDefaultImageForProductCommand;
use inklabs\kommerce\ActionHandler\Product\UnsetDefaultImageForProductHandler;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UnsetDefaultImageForProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $imageService = $this->mockService->getImageService();
        $productService = $this->mockService->getProductService();
        $productService->shouldReceive('update')
            ->once();

        $command = new UnsetDefaultImageForProductCommand(self::UUID_HEX);
        $handler = new UnsetDefaultImageForProductHandler($productService, $imageService);
        $handler->handle($command);
    }
}
