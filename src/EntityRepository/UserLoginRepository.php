<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Exception\BadMethodCallException;

class UserLoginRepository extends AbstractRepository implements UserLoginRepositoryInterface
{
    public function update(EntityInterface & $entity)
    {
        throw new BadMethodCallException('Update not allowed');
    }
}
