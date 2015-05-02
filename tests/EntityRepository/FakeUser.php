<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\UserInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class FakeUser extends Helper\AbstractFake implements UserInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\User);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAllUsers($queryString = null, Entity\Pagination &$pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllUsersByIds($userIds, Entity\Pagination &$pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function findOneByEmail($email)
    {
        return $this->getReturnValue();
    }

    public function createUserLogin(Entity\UserLogin $userLogin)
    {
    }

    public function save(Entity\User & $user)
    {
    }

    public function create(Entity\User & $user)
    {
    }

    public function persist(Entity\User & $user)
    {
    }

    public function flush()
    {
    }
}
