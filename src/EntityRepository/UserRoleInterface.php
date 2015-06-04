<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface UserRoleInterface
{
    public function save(Entity\UserRole & $userRole);
    public function create(Entity\UserRole & $userRole);
    public function remove(Entity\UserRole & $userRole);

    /**
     * @param int $id
     * @return Entity\UserRole
     */
    public function find($id);
}
