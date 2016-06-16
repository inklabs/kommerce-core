<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginWithTokenCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class LoginWithTokenHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $user = $this->dummyData->getUser();

        $userService = $this->mockService->getUserService();
        $userService->shouldReceive('loginWithToken')
            ->once();

        $command = new LoginWithTokenCommand(
            $user->getEmail(),
            'token123',
            self::IP4
        );

        $handler = new LoginWithTokenHandler($userService);
        $handler->handle($command);
    }
}
