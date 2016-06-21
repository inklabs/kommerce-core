<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\CreateUserCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateUserHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $userService = $this->mockService->getUserService();
        $userService->shouldReceive('create')
            ->once();

        $userDTO = $this->getDTOBuilderFactory()
            ->getUserDTOBuilder($this->dummyData->getUser())
            ->build();

        $command = new CreateUserCommand($userDTO);
        $handler = new CreateUserHandler($userService);
        $handler->handle($command);
    }
}
