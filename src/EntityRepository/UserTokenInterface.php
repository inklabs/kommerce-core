<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface UserTokenInterface
{
    /**
     * @param int $id
     * @return Entity\UserToken
     */
    public function find($id);
}
