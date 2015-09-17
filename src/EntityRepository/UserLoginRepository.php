<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserLogin;

class UserLoginRepository extends AbstractRepository implements UserLoginRepositoryInterface
{
    public function save(UserLogin & $userLogin)
    {
        $this->saveEntity($userLogin);
    }

    public function create(UserLogin & $userLogin)
    {
        $this->createEntity($userLogin);
    }

    public function remove(UserLogin & $userLogin)
    {
        $this->removeEntity($userLogin);
    }
}
