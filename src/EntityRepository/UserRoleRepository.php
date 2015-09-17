<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserRole;

class UserRoleRepository extends AbstractRepository implements UserRoleRepositoryInterface
{
    public function save(UserRole & $userRole)
    {
        $this->saveEntity($userRole);
    }

    public function create(UserRole & $userRole)
    {
        $this->createEntity($userRole);
    }

    public function remove(UserRole & $userRole)
    {
        $this->removeEntity($userRole);
    }
}
