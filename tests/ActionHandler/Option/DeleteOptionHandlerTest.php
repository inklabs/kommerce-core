<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteOptionHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $optionService = $this->mockService->getOptionService();
        $optionService->shouldReceive('delete')
            ->once();

        $command = new DeleteOptionCommand(self::UUID_HEX);
        $handler = new DeleteOptionHandler($optionService);
        $handler->handle($command);
    }
}
