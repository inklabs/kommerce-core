<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginCommand;
use inklabs\kommerce\Service\UserServiceInterface;

final class LoginHandler
{
    /** @var UserServiceInterface */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(LoginCommand $command)
    {
        $this->userService->login(
            $command->getEmail(),
            $command->getPassword(),
            $command->getRemoteIp4()
        );
    }
}
