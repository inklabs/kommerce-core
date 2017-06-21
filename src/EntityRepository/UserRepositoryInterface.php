<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method User findOneById(UuidInterface $id)
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    public function findOneByEmail(string $email): User;

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return User[]
     */
    public function getAllUsers(string $queryString = null, Pagination & $pagination = null);

    /**
     * @param UuidInterface[] $userIds
     * @param Pagination $pagination
     * @return User[]
     */
    public function getAllUsersByIds(array $userIds, Pagination & $pagination = null);

    public function findOneByExternalId(string $externalId): User;
}
