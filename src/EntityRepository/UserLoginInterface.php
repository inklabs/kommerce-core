<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface UserLoginInterface
{
    /**
     * @param int $id
     * @return Entity\UserLogin
     */
    public function find($id);

    /**
     * @param Entity\UserLogin $userLogin
     */
    public function create(Entity\UserLogin & $userLogin);

    /**
     * @param Entity\UserLogin $userLogin
     */
    public function save(Entity\UserLogin & $userLogin);

    /**
     * @param Entity\UserLogin $userLogin
     */
    public function persist(Entity\UserLogin & $userLogin);

    public function flush();
}
