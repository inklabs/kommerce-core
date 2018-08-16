<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method UserLogin findOneById(UuidInterface $id)
 */
interface UserLoginRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return UserLogin[]
     */
    public function getAllUserLogins(string $queryString = null, Pagination & $pagination = null);
}
