<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginWithTokenQuery;
use inklabs\kommerce\Service\UserServiceInterface;

final class LoginWithTokenHandler
{
    /** @var UserServiceInterface */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(LoginWithTokenQuery $query)
    {
        $request = $query->getRequest();

        $user = $this->userService->loginWithToken(
            $request->getEmail(),
            $request->getToken(),
            $request->getIp4()
        );

        $query->getResponse()->setUserDTO(
            $user->getDTOBuilder()
                ->withRoles()
                ->withTokens()
                ->build()
        );
    }
}
