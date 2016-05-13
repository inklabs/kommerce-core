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

        $command = new ChangePasswordCommand(1, 'newPassword123');
        $handler = new ChangePasswordHandler($userService);
        $handler->handle($command);
    }
}
