<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ChangePasswordCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ChangePasswordHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $userService = $this->mockService->getUserService();
        $userService->shouldReceive('changePassword')
            ->once();

        $user = $this->dummyData->getUser();

        $command = new ChangePasswordCommand(
            $user->getId()->getHex(),
            'newPassword123'
        );

        $handler = new ChangePasswordHandler($userService);
        $handler->handle($command);
    }
}
