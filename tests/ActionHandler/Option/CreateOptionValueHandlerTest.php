<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\CreateOptionValueCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateOptionValueHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $optionService = $this->mockService->getOptionService();
        $optionService->shouldReceive('createOptionValue')
            ->once();

        $optionValueDTO = $this->getDTOBuilderFactory()
            ->getOptionValueDTOBuilder($this->dummyData->getOptionValue())
            ->build();

        $command = new CreateOptionValueCommand(
            self::UUID_HEX,
            $optionValueDTO
        );
        $handler = new CreateOptionValueHandler($optionService);
        $handler->handle($command);
    }
}
