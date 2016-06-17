<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\RemoveTagFromProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveTagFromProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $productService = $this->mockService->getProductService();
        $productService->shouldReceive('addTag')
            ->once();

        $productId = self::UUID_HEX;
        $tagId = self::UUID_HEX;

        $command = new RemoveTagFromProductCommand($productId, $tagId);
        $handler = new RemoveTagFromProductHandler($productService);
        $handler->handle($command);
    }
}
