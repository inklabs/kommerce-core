<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\DeleteProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getProductService();
        $tagService->shouldReceive('delete')
            ->once();

        $command = new DeleteProductCommand(self::UUID_HEX);
        $handler = new DeleteProductHandler($tagService);
        $handler->handle($command);
    }
}
