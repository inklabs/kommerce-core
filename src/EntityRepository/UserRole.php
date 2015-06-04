<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class UserRole extends AbstractEntityRepository implements UserRoleInterface
{
    public function save(Entity\UserRole & $userRole)
    {
        $this->saveEntity($userRole);
    }

    public function create(Entity\UserRole & $userRole)
    {
        $this->createEntity($userRole);
    }

    public function remove(Entity\UserRole & $userRole)
    {
        $this->removeEntity($userRole);
    }
}
