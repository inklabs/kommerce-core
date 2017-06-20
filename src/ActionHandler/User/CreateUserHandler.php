<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\CreateUserCommand;
use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateUserHandler implements CommandHandlerInterface
{
    /** @var CreateUserCommand */
    private $command;

    /** @var UserRepositoryInterface */
    protected $userRepository;

    public function __construct(CreateUserCommand $command, UserRepositoryInterface $userRepository)
    {
        $this->command = $command;
        $this->userRepository = $userRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $user = UserDTOBuilder::createFromDTO(
            $this->command->getUserId(),
            $this->command->getUserDTO()
        );

        $this->userRepository->create($user);
    }
}
