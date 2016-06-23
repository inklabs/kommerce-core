<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\UpdateOptionCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateOptionHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $optionService = $this->mockService->getOptionService();
        $optionService->shouldReceive('update')
            ->once();

        $optionDTO = $this->getDTOBuilderFactory()
            ->getOptionDTOBuilder($this->dummyData->getOption())
            ->build();

        $command = new UpdateOptionCommand($optionDTO);
        $handler = new UpdateOptionHandler($optionService);
        $handler->handle($command);
    }
}
