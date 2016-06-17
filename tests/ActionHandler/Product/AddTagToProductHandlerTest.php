<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\AddTagToProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddTagToProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $productService = $this->mockService->getProductService();
        $productService->shouldReceive('addTag')
            ->once();

        $productId = self::UUID_HEX;
        $tagId = self::UUID_HEX;

        $command = new AddTagToProductCommand($productId, $tagId);
        $handler = new AddTagToProductHandler($productService);
        $handler->handle($command);
    }
}
