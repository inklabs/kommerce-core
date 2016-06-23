<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\DeleteOptionProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteOptionProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $optionService = $this->mockService->getOptionService();
        $optionService->shouldReceive('deleteOptionProduct')
            ->once();

        $command = new DeleteOptionProductCommand(self::UUID_HEX);
        $handler = new DeleteOptionProductHandler($optionService);
        $handler->handle($command);
    }
}
