<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\UserLoginInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class FakeUserLogin extends Helper\AbstractFake implements UserLoginInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\UserLogin);
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

    public function save(Entity\UserLogin & $userLogin)
    {
    }

    public function create(Entity\UserLogin & $userLogin)
    {
    }

    public function persist(Entity\UserLogin & $userLogin)
    {
    }

    public function flush()
    {
    }
}
