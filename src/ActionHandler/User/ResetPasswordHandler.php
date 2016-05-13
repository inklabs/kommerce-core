<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ResetPasswordCommand;
use inklabs\kommerce\Service\UserServiceInterface;

final class ResetPasswordHandler
{
    /** @var UserServiceInterface */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(ResetPasswordCommand $command)
    {
        $this->userService->requestPasswordResetToken(
            $command->getEmail(),
            $command->getUserAgent(),
            $command->getIp4()
        );
    }
}
