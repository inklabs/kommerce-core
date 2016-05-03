<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\UserToken;

/**
 * @method UserToken findOneById($id)
 */
interface UserTokenRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $getId
     * @return UserToken
     */
    public function findLatestOneByUserId($getId);
}
