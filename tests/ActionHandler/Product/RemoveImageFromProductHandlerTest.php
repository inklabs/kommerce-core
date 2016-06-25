<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\RemoveImageFromProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveImageFromProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $productService = $this->mockService->getProductService();
        $productService->shouldReceive('removeImage')
            ->once();

        $productId = self::UUID_HEX;
        $imageId = self::UUID_HEX;

        $command = new RemoveImageFromProductCommand($productId, $imageId);
        $handler = new RemoveImageFromProductHandler($productService);
        $handler->handle($command);
    }
}
