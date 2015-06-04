<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class UserToken extends AbstractEntityRepository implements UserTokenInterface
{
    public function save(Entity\UserToken & $userToken)
    {
        $this->saveEntity($userToken);
    }

    public function create(Entity\UserToken & $userToken)
    {
        $this->createEntity($userToken);
    }

    public function remove(Entity\UserToken & $userToken)
    {
        $this->removeEntity($userToken);
    }
}
