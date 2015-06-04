<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface UserTokenInterface
{
    public function save(Entity\UserToken & $userToken);
    public function create(Entity\UserToken & $userToken);
    public function remove(Entity\UserToken & $userToken);

    /**
     * @param int $id
     * @return Entity\UserToken
     */
    public function find($id);
}
