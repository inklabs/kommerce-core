<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method UserToken findOneById(UuidInterface $id)
 */
interface UserTokenRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface $userId
     * @return UserToken
     */
    public function findLatestOneByUserId(UuidInterface $userId);
}
