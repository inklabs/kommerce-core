<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserToken;

class UserTokenRepository extends AbstractRepository implements UserTokenRepositoryInterface
{
    public function save(UserToken & $userToken)
    {
        $this->saveEntity($userToken);
    }

    public function create(UserToken & $userToken)
    {
        $this->createEntity($userToken);
    }

    public function remove(UserToken & $userToken)
    {
        $this->removeEntity($userToken);
    }
}
