<?php
namespace inklabs\kommerce\ActionHandler\Product;

use inklabs\kommerce\Action\Product\CreateProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $productService = $this->mockService->getProductService();
        $productService->shouldReceive('create')
            ->once();

        $productDTO = $this->getDTOBuilderFactory()
            ->getProductDTOBuilder($this->dummyData->getProduct())
            ->build();

        $command = new CreateProductCommand($productDTO);
        $handler = new CreateProductHandler($productService);
        $handler->handle($command);
    }
}
