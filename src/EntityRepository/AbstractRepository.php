<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Lib;
use inklabs\kommerce\Doctrine\ORM\QueryBuilder;
use inklabs\kommerce\Entity\EntityInterface;
use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository
{
    public function getQueryBuilder()
    {
        return new QueryBuilder($this->getEntityManager());
    }

    public function saveEntity(EntityInterface & $entity)
    {
        $this->mergeEntity($entity);
        $this->flush();
    }

    public function createEntity(EntityInterface & $entity)
    {
        $this->persistEntity($entity);
        $this->flush();
    }

    public function removeEntity(EntityInterface $entity)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($entity);
        $this->flush();
    }

    public function persistEntity(EntityInterface & $entity)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);
    }

    public function mergeEntity(EntityInterface & $entity)
    {
        $entityManager = $this->getEntityManager();
        $entity = $entityManager->merge($entity);
    }

    public function flush()
    {
        $entityManager = $this->getEntityManager();
        $entityManager->flush();
    }
}
