<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ChangePasswordCommand;
use inklabs\kommerce\Service\UserServiceInterface;

final class ChangePasswordHandler
{
    /** @var UserServiceInterface */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(ChangePasswordCommand $command)
    {
        $this->userService->changePassword(
            $command->getUserId(),
            $command->getPassword()
        );
    }
}
