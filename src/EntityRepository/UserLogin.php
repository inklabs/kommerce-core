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
        $this->persist($userLogin);
        $this->flush();
    }

    public function persist(Entity\UserLogin & $userLogin)
    {
        $this->persistEntity($userLogin);
    }
}
