<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ChangePasswordCommand;
use inklabs\kommerce\Entity\EventGeneratorTrait;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Event\ReleaseEventsInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Lib\UserPasswordValidator;

final class ChangePasswordHandler implements CommandHandlerInterface, ReleaseEventsInterface
{
    use EventGeneratorTrait;

    /** @var ChangePasswordCommand */
    private $command;

    /** @var UserRepositoryInterface */
    private $userRepository;

    public function __construct(ChangePasswordCommand $command, UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->command = $command;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanManageUser($this->command->getUserId());
    }

    public function handle()
    {
        $user = $this->userRepository->findOneById($this->command->getUserId());

        $userPasswordValidator = new UserPasswordValidator();
        $userPasswordValidator->assertPasswordValid($user, $this->command->getPassword());

        $user->setPassword($this->command->getPassword());

        $this->userRepository->update($user);
        $this->raiseEvents($user->releaseEvents());
    }
}
