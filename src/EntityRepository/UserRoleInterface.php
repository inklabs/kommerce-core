<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface UserRoleInterface
{
    /**
     * @param int $id
     * @return Entity\UserRole
     */
    public function find($id);
}
