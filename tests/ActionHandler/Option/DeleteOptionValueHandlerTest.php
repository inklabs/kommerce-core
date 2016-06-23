<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionValueCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteOptionValueHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $optionService = $this->mockService->getOptionService();
        $optionService->shouldReceive('deleteOptionValue')
            ->once();

        $command = new DeleteOptionValueCommand(self::UUID_HEX);
        $handler = new DeleteOptionValueHandler($optionService);
        $handler->handle($command);
    }
}
