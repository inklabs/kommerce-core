<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;

class User extends AbstractService
{
    protected $sessionManager;
    protected $userSessionKey = 'user';

    /** @var EntityRepository\UserInterface */
    private $userRepository;

    /** @var EntityRepository\UserLoginInterface */
    private $userLoginRepository;

    /** @var Entity\User */
    protected $user;

    public function __construct(
        EntityRepository\UserInterface $userRepository,
        EntityRepository\UserLoginInterface $userLoginRepository,
        Lib\SessionManager $sessionManager
    ) {
        $this->sessionManager = $sessionManager;
        $this->userRepository = $userRepository;
        $this->userLoginRepository = $userLoginRepository;

        $this->load();
        $this->userLoginRepository = $userLoginRepository;
    }

    private function load()
    {
        $this->user = $this->sessionManager->get($this->userSessionKey);
    }

    private function save()
    {
        if ($this->user !== null) {
            $this->sessionManager->set($this->userSessionKey, $this->user);
        }
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $remoteIp
     * @return bool
     */
    public function login($email, $password, $remoteIp)
    {
        $entityUser = $this->userRepository->findOneByEmail($email);

        if ($entityUser === null || ! $entityUser->isActive()) {
            $this->recordLogin($email, $remoteIp, Entity\UserLogin::RESULT_FAIL);
            return false;
        }

        if ($entityUser->verifyPassword($password)) {
            $this->user = $entityUser;
            $this->save();
            $this->recordLogin($email, $remoteIp, Entity\UserLogin::RESULT_SUCCESS, $this->user);
            return true;
        } else {
            $this->recordLogin($email, $remoteIp, Entity\UserLogin::RESULT_FAIL, $entityUser);
            return false;
        }
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
            $user->addLogin($userLogin);
        }

        $this->userLoginRepository->save($userLogin);
    }

    public function logout()
    {
        $this->user = null;
        $this->sessionManager->delete($this->userSessionKey);
    }

    public function getUser()
    {
        return $this->user;
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

    public function getAllUsers($queryString = null, Entity\Pagination & $pagination = null)
    {
        $users = $this->userRepository
            ->getAllUsers($queryString, $pagination);

        return $this->getViewUsers($users);
    }

    public function getAllUsersByIds($userIds, Entity\Pagination & $pagination = null)
    {
        $users = $this->userRepository
            ->getAllUsersByIds($userIds);

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
