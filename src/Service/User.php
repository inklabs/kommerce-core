<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;

class User extends AbstractService
{
    protected $userSessionKey = 'user';

    /** @var EntityRepository\UserInterface */
    private $userRepository;

    /** @var EntityRepository\UserLoginInterface */
    private $userLoginRepository;

    public function __construct(
        EntityRepository\UserInterface $userRepository,
        EntityRepository\UserLoginInterface $userLoginRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userLoginRepository = $userLoginRepository;
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $remoteIp
     * @return bool
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

        return $user->getView()
            ->withRoles()
            ->withTokens()
            ->export();
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
     * @return View\User|null
     */
    public function find($id)
    {
        $entityUser = $this->userRepository->find($id);

        if ($entityUser === null || ! $entityUser->isActive()) {
            return null;
        }

        return $entityUser->getView()
            ->withAllData()
            ->export();
    }

    /**
     * @param Entity\User $user
     * @return Entity\User
     */
    public function edit(Entity\User $user)
    {
        $this->throwValidationErrors($user);
        $this->userRepository->save($user);
        return $user;
    }

    /**
     * @param Entity\User $user
     * @return Entity\User
     */
    public function create(Entity\User $user)
    {
        $this->throwValidationErrors($user);
        $this->userRepository->create($user);
        return $user;
    }

    public function getAllUsers($queryString = null, Entity\Pagination & $pagination = null)
    {
        $users = $this->userRepository->getAllUsers($queryString, $pagination);
        return $this->getViewUsers($users);
    }

    public function getAllUsersByIds($userIds, Entity\Pagination & $pagination = null)
    {
        $users = $this->userRepository->getAllUsersByIds($userIds, $pagination);
        return $this->getViewUsers($users);
    }

    /**
     * @param Entity\User[] $users
     * @return View\User[]
     */
    private function getViewUsers($users)
    {
        $viewUsers = [];
        foreach ($users as $user) {
            $viewUsers[] = $user->getView()
                ->export();
        }

        return $viewUsers;
    }
}
