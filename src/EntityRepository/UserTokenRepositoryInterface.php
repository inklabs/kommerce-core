<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserToken;
use Ramsey\Uuid\UuidInterface;

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
