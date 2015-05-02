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
     * @return Entity\User|null
     */
    public function findOneByEmail($email);

    /**
     * @param Entity\User $user
     */
    public function create(Entity\User & $user);

    /**
     * @param Entity\User $product
     */
    public function save(Entity\User & $product);

    /**
     * @param Entity\User $product
     */
    public function persist(Entity\User & $product);

    public function flush();
}
