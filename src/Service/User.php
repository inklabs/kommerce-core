<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\UserLoginRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Lib;

class User extends AbstractService
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

    public function create(Entity\User & $user)
    {
        $this->throwValidationErrors($user);
        $this->userRepository->create($user);
    }

    public function edit(Entity\User & $user)
    {
        $this->throwValidationErrors($user);
        $this->userRepository->save($user);
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $remoteIp
     * @return Entity\User
     * @throws UserLoginException
     */
    public function login($email, $password, $remoteIp)
    {
        /** @var Entity\User $user */
        $user = $this->userRepository->findOneByEmail($email);

        if ($user === null) {
            $this->recordLogin($email, $remoteIp, Entity\UserLogin::RESULT_FAIL);
            throw new UserLoginException('User not found', UserLoginException::USER_NOT_FOUND);
        }

        if (! $user->isActive()) {
            $this->recordLogin($email, $remoteIp, Entity\UserLogin::RESULT_FAIL);
            throw new UserLoginException('User not active', UserLoginException::USER_NOT_ACTIVE);
        }

        if (! $user->verifyPassword($password)) {
            $this->recordLogin($email, $remoteIp, Entity\UserLogin::RESULT_FAIL, $user);
            throw new UserLoginException('User password not valid', UserLoginException::INVALID_PASSWORD);
        }

        $this->recordLogin($email, $remoteIp, Entity\UserLogin::RESULT_SUCCESS, $user);

        return $user;
    }

    /**
     * @param string $email
     * @param string $remoteIp
     * @param int $status
     * @param Entity\User $user
     */
    protected function recordLogin($email, $remoteIp, $status, Entity\User $user = null)
    {
        $userLogin = new Entity\UserLogin;
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
     * @return Entity\User|null
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return Entity\User[]
     */
    public function getAllUsers($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->userRepository->getAllUsers($queryString, $pagination);
    }

    public function getAllUsersByIds($userIds, Entity\Pagination & $pagination = null)
    {
        return $this->userRepository->getAllUsersByIds($userIds, $pagination);
    }
}
