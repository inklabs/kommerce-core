<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateOptionProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $optionService = $this->mockService->getOptionService();
        $optionService->shouldReceive('updateOptionProduct')
            ->once();

        $optionProductDTO = $this->getDTOBuilderFactory()
            ->getOptionProductDTOBuilder($this->dummyData->getOptionProduct())
            ->build();

        $command = new UpdateOptionProductCommand($optionProductDTO);
        $handler = new UpdateOptionProductHandler($optionService);
        $handler->handle($command);
    }
}
