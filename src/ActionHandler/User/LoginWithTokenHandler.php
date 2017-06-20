<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginWithTokenCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\UserServiceInterface;

final class LoginWithTokenHandler implements CommandHandlerInterface
{
    /** @var UserServiceInterface */
    private $userService;

    /** @var LoginWithTokenCommand */
    private $command;

    public function __construct(LoginWithTokenCommand $command, UserServiceInterface $userService)
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
        $this->userService->loginWithToken(
            $this->command->getEmail(),
            $this->command->getToken(),
            $this->command->getRemoteIp4()
        );
    }
}
