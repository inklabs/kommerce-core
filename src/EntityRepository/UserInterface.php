<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface UserInterface
{
    /**
     * @param int $id
     * @return Entity\User
     */
    function find($id);

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
     * @param Entity\EntityInterface $entity
     */
    public function create(Entity\EntityInterface & $entity);

    /**
     * @param Entity\EntityInterface $entity
     */
    public function save(Entity\EntityInterface & $entity);
}
