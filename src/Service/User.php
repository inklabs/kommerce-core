<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Lib as Lib;

class User extends Lib\ServiceManager
{
    protected $sessionManager;
    protected $userSessionKey = 'newuser';

    /** @var EntityRepository\User */
    private $userRepository;

    /** @var Entity\User */
    protected $user;

    public function __construct(EntityManager $entityManager, Lib\SessionManager $sessionManager)
    {
        $this->setEntityManager($entityManager);
        $this->sessionManager = $sessionManager;
        $this->userRepository = $entityManager->getRepository('kommerce:User');

        $this->load();
    }

    private function load()
    {
        $this->user = $this->sessionManager->get($this->userSessionKey);

        if ($this->user !== null) {
            $this->user = $this->entityManager->merge($this->user);
        }
    }

    private function save()
    {
        if ($this->user !== null) {
            $this->entityManager->detach($this->user);
            $this->sessionManager->set($this->userSessionKey, $this->user);
            $this->user = $this->entityManager->merge($this->user);
        }
    }

    /**
     * @return bool
     */
    public function login($username, $password, $remoteIp)
    {
        /** @var Entity\User $entityUser */
        $entityUser = $this->entityManager->getRepository('kommerce:User')
            ->findOneByUsernameOrEmail($username);

        if ($entityUser === null || ! $entityUser->isActive()) {
            $this->recordLogin($username, $remoteIp, Entity\UserLogin::RESULT_FAIL);
            return false;
        }

        if ($entityUser->verifyPassword($password)) {
            $this->user = $entityUser;
            $this->save();
            $this->recordLogin($username, $remoteIp, Entity\UserLogin::RESULT_SUCCESS, $this->user);
            return true;
        } else {
            $this->recordLogin($username, $remoteIp, Entity\UserLogin::RESULT_FAIL, $entityUser);
            return false;
        }
    }

    public function logout()
    {
        $this->user = null;
        $this->sessionManager->delete($this->userSessionKey);
    }

    protected function recordLogin($username, $remoteIp, $status, Entity\User $user = null)
    {
        $userLogin = new Entity\UserLogin;
        $userLogin->setUsername($username);
        $userLogin->setIp4($remoteIp);
        $userLogin->setResult($status);

        if ($user !== null) {
            $user->addLogin($userLogin);

            if ($status == Entity\UserLogin::RESULT_SUCCESS) {
                $user->incrementTotalLogins();
            }
        }

        $this->entityManager->persist($userLogin);
        $this->entityManager->flush();
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Entity\View\User|null
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
     * @return Entity\View\User[]
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
