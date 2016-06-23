<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateOptionHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $optionService = $this->mockService->getOptionService();
        $optionService->shouldReceive('create')
            ->once();

        $optionDTO = $this->getDTOBuilderFactory()
            ->getOptionDTOBuilder($this->dummyData->getOption())
            ->build();

        $command = new CreateOptionCommand($optionDTO);
        $handler = new CreateOptionHandler($optionService);
        $handler->handle($command);
    }
}
