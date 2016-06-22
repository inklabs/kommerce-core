<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ListUsersQuery;
use inklabs\kommerce\Action\User\Query\ListUsersRequest;
use inklabs\kommerce\Action\User\Query\ListUsersResponse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListUsersHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $userService = $this->mockService->getUserService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $queryString = 'john';
        $request = new ListUsersRequest($queryString, new PaginationDTO);
        $response = new ListUsersResponse();

        $handler = new ListUsersHandler($userService, $dtoBuilderFactory);
        $handler->handle(new ListUsersQuery($request, $response));

        $this->assertTrue($response->getUserDTOs()[0] instanceof UserDTO);
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
