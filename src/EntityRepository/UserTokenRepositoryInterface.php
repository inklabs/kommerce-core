<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method UserToken findOneById(UuidInterface $id)
 */
interface UserTokenRepositoryInterface extends RepositoryInterface
{
    public function findLatestOneByUserId(UuidInterface $userId): UserToken;
}
