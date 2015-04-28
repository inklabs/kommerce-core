<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class UserLogin extends AbstractEntityRepository implements UserLoginInterface
{
    public function save(Entity\UserLogin & $userLogin)
    {
        $this->saveEntity($userLogin);
    }

    public function create(Entity\UserLogin & $userLogin)
    {
        $this->createEntity($userLogin);
    }

    public function persist(Entity\UserLogin & $userLogin)
    {
        $this->persistEntity($userLogin);
    }

    public function flush()
    {
        $this->flushEntity();
    }
}
