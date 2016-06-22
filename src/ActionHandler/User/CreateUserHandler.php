<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\CreateUserCommand;
use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;
use inklabs\kommerce\Service\UserServiceInterface;

final class CreateUserHandler
{
    /** @var UserServiceInterface */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(CreateUserCommand $command)
    {
        $user = UserDTOBuilder::createFromDTO(
            $command->getUserId(),
            $command->getUserDTO()
        );

        $this->userService->create($user);
    }
}
