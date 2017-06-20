<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\UserServiceInterface;

final class LoginHandler implements CommandHandlerInterface
{
    /** @var UserServiceInterface */
    private $userService;

    /** @var LoginCommand */
    private $command;

    public function __construct(LoginCommand $command, UserServiceInterface $userService)
    {
        $this->userService = $userService;
        $this->command = $command;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanMakeRequests();
    }

    public function handle()
    {
        $this->userService->login(
            $this->command->getEmail(),
            $this->command->getPassword(),
            $this->command->getRemoteIp4()
        );
    }
}
