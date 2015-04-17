<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;

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

            if ($status == Entity\UserLogin::RESULT_SUCCESS) {
                $user->incrementTotalLogins();
            }
        }

        $this->entityManager->persist($userLogin);
        $this->entityManager->flush();
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
