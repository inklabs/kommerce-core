<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionValueCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateOptionValueHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $optionService = $this->mockService->getOptionService();
        $optionService->shouldReceive('updateOptionValue')
            ->once();

        $optionValueDTO = $this->getDTOBuilderFactory()
            ->getOptionValueDTOBuilder($this->dummyData->getOptionValue())
            ->build();

        $command = new UpdateOptionValueCommand($optionValueDTO);
        $handler = new UpdateOptionValueHandler($optionService);
        $handler->handle($command);
    }
}
