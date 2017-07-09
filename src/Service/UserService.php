<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserLoginResultType;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;
use inklabs\kommerce\Exception\UserLoginException;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;

class UserService implements UserServiceInterface
{
    use EntityValidationTrait;

    protected $userSessionKey = 'user';

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var UserLoginRepositoryInterface */
    private $userLoginRepository;

    /** @var UserTokenRepositoryInterface */
    private $userTokenRepository;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserLoginRepositoryInterface $userLoginRepository,
        UserTokenRepositoryInterface $userTokenRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->userLoginRepository = $userLoginRepository;
        $this->userTokenRepository = $userTokenRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function login(string $email, string $password, string $remoteIp): User
    {
        $user = $this->getUserOrAssertAndRecordLoginFailure($email, $remoteIp);

        if (! $user->verifyPassword($password)) {
            $this->recordLogin($email, $remoteIp, UserLoginResultType::fail(), $user);
            throw UserLoginException::invalidPassword();
        }

        $this->recordLogin($email, $remoteIp, UserLoginResultType::success(), $user);

        return $user;
    }

    public function loginWithToken(string $email, string $token, string $remoteIp): User
    {
        $user = $this->getUserOrAssertAndRecordLoginFailure($email, $remoteIp);

        try {
            $userToken = $this->userTokenRepository->findLatestOneByUserId($user->getId());
        } catch (EntityNotFoundException $e) {
            $this->recordLogin($email, $remoteIp, UserLoginResultType::fail(), $user);
            throw UserLoginException::tokenNotFound();
        }

        if (! $userToken->verifyToken($token)) {
            $this->recordLogin($email, $remoteIp, UserLoginResultType::fail(), $user);
            throw UserLoginException::tokenNotValid();
        }

        if (! $userToken->verifyTokenDateValid()) {
            $this->recordLogin($email, $remoteIp, UserLoginResultType::fail(), $user);
            throw UserLoginException::tokenExpired();
        }

        $this->recordLogin($email, $remoteIp, UserLoginResultType::success(), $user, $userToken);

        return $user;
    }

    protected function recordLogin(
        string $email,
        string $ip4,
        UserLoginResultType $result,
        User $user = null,
        UserToken $userToken = null
    ): void {
        $userLogin = new UserLogin($result, $email, $ip4, $user, $userToken);
        $this->userLoginRepository->create($userLogin);
    }

    private function getUserOrAssertAndRecordLoginFailure(string $email, string $remoteIp): User
    {
        try {
            $user = $this->userRepository->findOneByEmail($email);
        } catch (EntityNotFoundException $e) {
            $this->recordLogin($email, $remoteIp, UserLoginResultType::fail());
            throw UserLoginException::userNotFound();
        }

        if (! $user->getStatus()->isActive()) {
            $this->recordLogin($email, $remoteIp, UserLoginResultType::fail(), $user);
            throw UserLoginException::userNotActive();
        }

        return $user;
    }
}
