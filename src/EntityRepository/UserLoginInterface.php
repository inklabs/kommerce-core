<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface UserLoginInterface
{
    public function save(Entity\UserLogin & $userLogin);
    public function create(Entity\UserLogin & $userLogin);
    public function remove(Entity\UserLogin & $userLogin);

    /**
     * @param int $id
     * @return Entity\UserLogin
     */
    public function find($id);
}
