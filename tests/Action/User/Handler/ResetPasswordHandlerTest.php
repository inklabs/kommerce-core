<?php
namespace inklabs\kommerce\Action\User\Handler;

use inklabs\kommerce\Action\User\ResetPasswordCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ResetPasswordHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $userService = $this->mockService->getUserService();
        $userService->shouldReceive('requestPasswordResetToken')
            ->once();

        $command = new ResetPasswordCommand(
            'test1@example.com',
            '127.0.0.1',
            'SampleBot/1.1'
        );

        $handler = new ResetPasswordHandler($userService);
        $handler->handle($command);
    }
}
