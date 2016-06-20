<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserQuery;
use inklabs\kommerce\Action\User\Query\GetUserRequest;
use inklabs\kommerce\Action\User\Query\GetUserResponse;
use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetUserHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $userService = $this->mockService->getUserService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetUserRequest(self::UUID_HEX);
        $response = new GetUserResponse();

        $handler = new GetUserHandler($userService, $dtoBuilderFactory);

        $handler->handle(new GetUserQuery($request, $response));
        $this->assertTrue($response->getUserDTO() instanceof UserDTO);

        $handler->handle(new GetUserQuery($request, $response));
        $this->assertTrue($response->getUserDTOWithRolesAndTokens() instanceof UserDTO);
    }
}
