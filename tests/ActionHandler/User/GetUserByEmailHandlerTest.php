<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserByEmailQuery;
use inklabs\kommerce\Action\User\Query\GetUserByEmailRequest;
use inklabs\kommerce\Action\User\Query\GetUserByEmailResponse;
use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetUserByEmailHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $pricing = $this->dummyData->getPricing();
        $userService = $this->mockService->getUserService();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $request = new GetUserByEmailRequest(self::UUID_HEX);
        $response = new GetUserByEmailResponse($pricing);

        $handler = new GetUserByEmailHandler($userService, $dtoBuilderFactory);

        $handler->handle(new GetUserByEmailQuery($request, $response));
        $this->assertTrue($response->getUserDTO() instanceof UserDTO);
    }
}
