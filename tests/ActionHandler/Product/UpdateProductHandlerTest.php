<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\UpdateProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->mockService->getProductService();
        $tagService->shouldReceive('update')
            ->once();

        $tagDTO = $this->getDTOBuilderFactory()
            ->getProductDTOBuilder($this->dummyData->getProduct())
            ->build();

        $command = new UpdateProductCommand($tagDTO);
        $handler = new UpdateProductHandler($tagService);
        $handler->handle($command);
    }
}
