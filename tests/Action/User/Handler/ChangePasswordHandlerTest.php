<?php
namespace inklabs\kommerce\Action\User\Handler;

use inklabs\kommerce\Action\User\ChangePasswordCommand;
use inklabs\kommerce\Service\UserServiceInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use Mockery;

class ChangePasswordHandlerTest extends DoctrineTestCase
{
    public function testHandle()
    {
        $userService = Mockery::mock(UserServiceInterface::class);
        $userService->shouldReceive('changePassword')
            ->once();
        /** @var UserServiceInterface $userService */

        $command = new ChangePasswordCommand(
            1,
            'newPassword123'
        );

        $handler = new ChangePasswordHandler($userService);
        $handler->handle($command);
    }
}
