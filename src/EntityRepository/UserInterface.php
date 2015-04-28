<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface UserInterface
{
    /**
     * @param int $id
     * @return Entity\User
     */
    public function find($id);

    /**
     * @param Entity\User $user
     */
    public function persist(Entity\User & $user);

    public function flush();

    /**
     * @param string $queryString
     * @return Entity\User[]
     */
    public function getAllUsers($queryString = null, Entity\Pagination &$pagination = null);

    /**
     * @param int[] $userIds
     * @return Entity\User[]
     */
    public function getAllUsersByIds($userIds, Entity\Pagination &$pagination = null);

    /**
     * @param string $email
     * @return Entity\User
     */
    public function findOneByEmail($email);

    /**
     * @param Entity\User $user
     */
    public function create(Entity\User & $user);

    /**
     * @param Entity\User $user
     */
    public function save(Entity\User & $user);
}
