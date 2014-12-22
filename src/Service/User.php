<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class User extends Lib\EntityManager
{
    protected $sessionManager;
    protected $userSessionKey = 'newuser';

    /* @var Entity\User */
    protected $user;

    public function __construct(EntityManager $entityManager, Lib\SessionManager $sessionManager)
    {
        $this->setEntityManager($entityManager);
        $this->sessionManager = $sessionManager;

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
        /* @var Entity\User $entityUser */
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

    /**
     * @return Entity\View\User|null
     */
    public function find($id)
    {
        $entityUser = $this->entityManager->getRepository('kommerce:User')->find($id);

        if ($entityUser === null || ! $entityUser->isActive()) {
            return null;
        }

        return $entityUser->getView()
            ->withAllData()
            ->export();
    }

    /**
     * @return Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
