<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginWithTokenQuery;
use inklabs\kommerce\Action\User\Query\LoginWithTokenRequest;
use inklabs\kommerce\Action\User\Query\LoginWithTokenResponse;
use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class LoginWithTokenHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $userService = $this->mockService->getUserService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new LoginWithTokenRequest(
            'test1@example.com',
            'xxxx',
            '8.8.8.8'
        );
        $response = new LoginWithTokenResponse;

        $handler = new LoginWithTokenHandler($userService, $dtoBuilderFactory);
        $handler->handle(new LoginWithTokenQuery($request, $response));

        $this->assertTrue($response->getUserDTO() instanceof UserDTO);
    }
}
