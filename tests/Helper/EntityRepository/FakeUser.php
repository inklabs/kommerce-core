<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Entity;

class FakeRepositoryUserRepository extends AbstractFakeRepository implements UserRepositoryInterface
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

    public function remove(Entity\User & $user)
    {
    }
}
