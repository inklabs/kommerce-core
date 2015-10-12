<?php
namespace inklabs\kommerce\EntityRepository;

use BadMethodCallException;
use inklabs\kommerce\Entity\EntityInterface;

class UserLoginRepository extends AbstractRepository implements UserLoginRepositoryInterface
{
    public function update(EntityInterface & $entity)
    {
        throw new BadMethodCallException('Update not allowed');
    }
}
