<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateOptionProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $productService = $this->mockService->getProductService();
        $optionService = $this->mockService->getOptionService();
        $optionService->shouldReceive('createOptionProduct')
            ->once();

        $optionProductDTO = $this->getDTOBuilderFactory()
            ->getOptionProductDTOBuilder($this->dummyData->getOptionProduct())
            ->build();

        $command = new CreateOptionProductCommand(
            self::UUID_HEX,
            self::UUID_HEX,
            $optionProductDTO
        );
        $handler = new CreateOptionProductHandler($optionService, $productService);
        $handler->handle($command);
    }
}
