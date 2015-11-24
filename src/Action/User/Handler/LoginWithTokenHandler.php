<?php
namespace inklabs\kommerce\Action\User\Handler;

use inklabs\kommerce\Action\User\LoginWithTokenRequest;
use inklabs\kommerce\Action\User\Response\LoginWithTokenResponseInterface;
use inklabs\kommerce\Service\UserServiceInterface;

final class LoginWithTokenHandler
{
    /** @var UserServiceInterface */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(LoginWithTokenRequest $request, LoginWithTokenResponseInterface & $response)
    {
        $user = $this->userService->loginWithToken(
            $request->getEmail(),
            $request->getToken(),
            $request->getIp4()
        );

        $response->setUserDTO(
            $user->getDTOBuilder()
                ->withRoles()
                ->withTokens()
                ->build()
        );
    }
}
