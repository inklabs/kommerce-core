<?php
namespace inklabs\kommerce\Action\User\Handler;

use inklabs\kommerce\Action\User\ResetPasswordCommand;
use inklabs\kommerce\Service\UserServiceInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use Mockery;

class ResetPasswordHandlerTest extends DoctrineTestCase
{
    public function testHandle()
    {
        $userService = Mockery::mock(UserServiceInterface::class);
        $userService->shouldReceive('requestPasswordResetToken')
            ->once();
        /** @var UserServiceInterface $userService */

        $command = new ResetPasswordCommand(
            'test1@example.com',
            '127.0.0.1',
            'SampleBot/1.1'
        );

        $handler = new ResetPasswordHandler($userService);
        $handler->handle($command);
    }
}
