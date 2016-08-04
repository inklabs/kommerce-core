<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateTextOptionCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateTextOptionHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $optionService = $this->mockService->getOptionService();
        $optionService->shouldReceive('createTextOption')
            ->once();

        $command = new CreateTextOptionCommand(
            'John Doe',
            'Test Description',
            1,
            $this->dummyData->getTextOptionType()->getId()
        );
        $handler = new CreateTextOptionHandler($optionService);
        $handler->handle($command);
    }
}
