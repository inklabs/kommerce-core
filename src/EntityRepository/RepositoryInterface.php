<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\QueryBuilder;
use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface RepositoryInterface
{
    public function getQueryBuilder(): QueryBuilder;
    public function create(EntityInterface & $entity): void;
    public function update(EntityInterface & $entity): void;
    public function delete(EntityInterface $entity): void;
    public function remove(EntityInterface $entity): void;
    public function persist(EntityInterface & $entity): void;
    public function flush(): void;

    /**
     * @param UuidInterface $id
     * @return EntityInterface
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);
}
