<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class LoginHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $user = $this->dummyData->getUser();

        $userService = $this->mockService->getUserService();
        $userService->shouldReceive('login')
            ->once();

        $command = new LoginCommand($user->getEmail(), 'password1', self::IP4);
        $handler = new LoginHandler($userService);
        $handler->handle($command);
    }
}
