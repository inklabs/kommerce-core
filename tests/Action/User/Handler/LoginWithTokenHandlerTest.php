<?php
namespace inklabs\kommerce\Action\User\Handler;

use inklabs\kommerce\Action\User\LoginWithTokenRequest;
use inklabs\kommerce\Action\User\Response\LoginWithTokenResponse;
use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\Service\UserServiceInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use Mockery;

class LoginWithTokenHandlerTest extends DoctrineTestCase
{
    public function testHandle()
    {
        $userService = Mockery::mock(UserServiceInterface::class);
        $userService->shouldReceive('loginWithToken')
            ->andReturn(
                $this->dummyData->getUser()
            );
        /** @var UserServiceInterface $userService */

        $request = new LoginWithTokenRequest(
            'test1@example.com',
            'xxxx',
            '8.8.8.8'
        );

        $response = new LoginWithTokenResponse;

        $handler = new LoginWithTokenHandler($userService);
        $handler->handle($request, $response);

        $this->assertTrue($response->getUserDTO() instanceof UserDTO);
    }
}
