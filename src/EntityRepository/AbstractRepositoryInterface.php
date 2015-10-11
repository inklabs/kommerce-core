<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\EntityInterface;

interface AbstractRepositoryInterface
{
    public function getQueryBuilder();
    public function save(EntityInterface & $entity);
    public function create(EntityInterface & $entity);
    public function remove(EntityInterface $entity);
    public function persist(EntityInterface & $entity);
    public function merge(EntityInterface & $entity);
    public function flush();

    /**
     * @param int $id
     * @return EntityInterface
     * @throws EntityNotFoundException
     */
    public function findOneById($id);
}
