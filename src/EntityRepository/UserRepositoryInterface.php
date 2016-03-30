<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Exception\EntityNotFoundException;

/**
 * @method User findOneById($id)
 */
interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $email
     * @return User
     * @throws EntityNotFoundException
     */
    public function findOneByEmail($email);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return User[]
     */
    public function getAllUsers($queryString = null, Pagination & $pagination = null);

    /**
     * @param int[] $userIds
     * @param Pagination $pagination
     * @return User[]
     */
    public function getAllUsersByIds($userIds, Pagination & $pagination = null);

    /**
     * @param string $externalId
     * @return User|null
     */
    public function findOneByExternalId($externalId);
}
