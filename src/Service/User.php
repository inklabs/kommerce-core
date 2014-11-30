<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use Exception;

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

        if (! ($this->user instanceof Entity\User)) {
            $this->user = new Entity\User;
        }
    }

    public function login($username, $password)
    {
        $entityUser = $this->entityManager->getRepository('inklabs\kommerce\Entity\User')->findOneByUsername($username);

        if ($entityUser === null || ! $entityUser->isActive()) {
            return null;
        }

        if ($entityUser->verifyPassword($password)) {
            $this->user = $entityUser;
            $this->user->incrementTotalLogins();
            $this->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return Entity\View\User|null
     */
    public function find($id)
    {
        $entityUser = $this->entityManager->getRepository('inklabs\kommerce\Entity\User')->find($id);

        if ($entityUser === null || ! $entityUser->isActive()) {
            return null;
        }

        return Entity\View\User::factory($entityUser)
            ->withAllData()
            ->export();
    }

    private function save()
    {
        $this->sessionManager->set($this->userSessionKey, $this->user);
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Entity\View\User
     */
    public function getView()
    {
        return Entity\View\User::factory($this->user)
            ->withAllData()
            ->export();
    }
}
