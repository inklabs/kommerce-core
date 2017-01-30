<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ResetPasswordCommand;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;
use inklabs\kommerce\Event\RaiseEventTrait;
use inklabs\kommerce\Event\ReleaseEventsInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class ResetPasswordHandler implements CommandHandlerInterface, ReleaseEventsInterface
{
    use RaiseEventTrait;

    /** @var ResetPasswordCommand */
    private $command;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var UserTokenRepositoryInterface */
    private $userTokenRepository;

    public function __construct(
        ResetPasswordCommand $command,
        UserRepositoryInterface $userRepository,
        UserTokenRepositoryInterface $userTokenRepository
    ) {
        $this->command = $command;
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $user = $this->userRepository->findOneByEmail($this->command->getEmail());
        $authorizationContext->verifyCanManageUser($user->getId());
    }

    public function handle()
    {
        $user = $this->userRepository->findOneByEmail($this->command->getEmail());

        $userToken = UserToken::createResetPasswordToken(
            $user,
            UserToken::getRandomToken(),
            $this->command->getUserAgent(),
            $this->command->getIp4()
        );

        $this->userTokenRepository->create($userToken);
        $this->raiseEvents($userToken->releaseEvents());
    }
}
