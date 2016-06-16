<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginWithTokenCommand;
use inklabs\kommerce\Service\UserServiceInterface;

final class LoginWithTokenHandler
{
    /** @var UserServiceInterface */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(LoginWithTokenCommand $command)
    {
        $this->userService->loginWithToken(
            $command->getEmail(),
            $command->getToken(),
            $command->getRemoteIp4()
        );
    }
}
