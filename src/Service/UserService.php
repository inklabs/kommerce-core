<?php
namespace inklabs\kommerce\Service;

use DateTime;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;
use inklabs\kommerce\Event\ResetPasswordEvent;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;

class UserService extends AbstractService implements UserServiceInterface
{
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

    public function create(User & $user)
    {
        $this->throwValidationErrors($user);
        $this->userRepository->create($user);
    }

    public function update(User & $user)
    {
        $this->throwValidationErrors($user);
        $this->userRepository->update($user);
    }

    public function delete($userId)
    {
        $tag = $this->userRepository->findOneById($userId);
        $this->userRepository->delete($tag);
    }

    public function login($email, $password, $remoteIp)
    {
        try {
            $user = $this->userRepository->findOneByEmail($email);
        } catch (EntityNotFoundException $e) {
            $this->recordLogin($email, $remoteIp, UserLogin::RESULT_FAIL);
            throw new UserLoginException('User not found', UserLoginException::USER_NOT_FOUND);
        }

        if (! $user->isActive()) {
            $this->recordLogin($email, $remoteIp, UserLogin::RESULT_FAIL);
            throw new UserLoginException('User not active', UserLoginException::USER_NOT_ACTIVE);
        }

        if (! $user->verifyPassword($password)) {
            $this->recordLogin($email, $remoteIp, UserLogin::RESULT_FAIL, $user);
            throw new UserLoginException('User password not valid', UserLoginException::INVALID_PASSWORD);
        }

        $this->recordLogin($email, $remoteIp, UserLogin::RESULT_SUCCESS, $user);

        return $user;
    }

    public function loginWithToken($email, $token, $remoteIp)
    {
        try {
            $user = $this->userRepository->findOneByEmail($email);
        } catch (EntityNotFoundException $e) {
            $this->recordLogin($email, $remoteIp, UserLogin::RESULT_FAIL);
            throw new UserLoginException('User not found', UserLoginException::USER_NOT_FOUND);
        }

        if (! $user->isActive()) {
            $this->recordLogin($email, $remoteIp, UserLogin::RESULT_FAIL);
            throw new UserLoginException('User not active', UserLoginException::USER_NOT_ACTIVE);
        }

        try {
            $userToken = $this->userTokenRepository->findLatestOneByUserId($user->getId());
        } catch (EntityNotFoundException $e) {
            $this->recordLogin($email, $remoteIp, UserLogin::RESULT_FAIL, $user);
            throw new UserLoginException('Token not found', UserLoginException::TOKEN_NOT_FOUND);
        }

        if (! $userToken->verifyToken($token)) {
            $this->recordLogin($email, $remoteIp, UserLogin::RESULT_FAIL, $user);
            throw new UserLoginException('Token not valid', UserLoginException::TOKEN_INVALID);
        }

        if (! $userToken->verifyTokenDateValid()) {
            $this->recordLogin($email, $remoteIp, UserLogin::RESULT_FAIL, $user);
            throw new UserLoginException('Token expired', UserLoginException::TOKEN_EXPIRED);
        }

        $this->recordLogin($email, $remoteIp, UserLogin::RESULT_SUCCESS, $user);

        return $user;
    }


    /**
     * @param string $email
     * @param string $remoteIp
     * @param int $status
     * @param User $user
     */
    protected function recordLogin($email, $remoteIp, $status, User $user = null)
    {
        $userLogin = new UserLogin;
        $userLogin->setEmail($email);
        $userLogin->setIp4($remoteIp);
        $userLogin->setResult($status);

        if ($user !== null) {
            $userLogin->setUser($user);
        }

        $this->userLoginRepository->create($userLogin);
    }

    public function findOneById($id)
    {
        return $this->userRepository->findOneById($id);
    }

    public function findOneByEmail($email)
    {
        return $this->userRepository->findOneByemail($email);
    }

    public function getAllUsers($queryString = null, Pagination & $pagination = null)
    {
        return $this->userRepository->getAllUsers($queryString, $pagination);
    }

    public function getAllUsersByIds($userIds, Pagination & $pagination = null)
    {
        return $this->userRepository->getAllUsersByIds($userIds, $pagination);
    }

    public function requestPasswordResetToken($email, $userAgent, $ip4)
    {
        $user = $this->userRepository->findOneByEmail($email);

        $token = UserToken::getRandomToken();

        $userToken = new UserToken;
        $userToken->setToken($token);
        $userToken->setUserAgent($userAgent);
        $userToken->setIp4($ip4);
        $userToken->setExpires(new DateTime('+1 hour'));
        $userToken->setUser($user);

        $this->userTokenRepository->create($userToken);

        $this->eventDispatcher->dispatchEvent(
            new ResetPasswordEvent(
                $user->getId(),
                $user->getEmail(),
                $user->getFullName(),
                $token
            )
        );
    }
}
