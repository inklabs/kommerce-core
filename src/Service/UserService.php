<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;

class UserService extends AbstractService
{
    protected $userSessionKey = 'user';

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var UserLoginRepositoryInterface */
    private $userLoginRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserLoginRepositoryInterface $userLoginRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userLoginRepository = $userLoginRepository;
    }

    public function create(User & $user)
    {
        $this->throwValidationErrors($user);
        $this->userRepository->create($user);
    }

    public function edit(User & $user)
    {
        $this->throwValidationErrors($user);
        $this->userRepository->save($user);
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $remoteIp
     * @return User
     * @throws UserLoginException
     */
    public function login($email, $password, $remoteIp)
    {
        /** @var User $user */
        $user = $this->userRepository->findOneByEmail($email);

        if ($user === null) {
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

    /**
     * @param int $id
     * @return User|null
     */
    public function findOneById($id)
    {
        return $this->userRepository->findOneById($id);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findOneByEmail($email)
    {
        return $this->userRepository->findOneByemail($email);
    }

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return User[]
     */
    public function getAllUsers($queryString = null, Pagination & $pagination = null)
    {
        return $this->userRepository->getAllUsers($queryString, $pagination);
    }

    public function getAllUsersByIds($userIds, Pagination & $pagination = null)
    {
        return $this->userRepository->getAllUsersByIds($userIds, $pagination);
    }
}
