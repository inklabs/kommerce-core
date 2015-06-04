<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Lib;
use inklabs\kommerce\Doctrine\ORM\QueryBuilder;
use inklabs\kommerce\Entity\EntityInterface;

abstract class AbstractEntityRepository extends \Doctrine\ORM\EntityRepository
{
    public function getQueryBuilder()
    {
        return new QueryBuilder($this->getEntityManager());
    }

    public function saveEntity(EntityInterface & $entity)
    {
        $entityManager = $this->getEntityManager();
        $entity = $entityManager->merge($entity);
        $entityManager->flush();
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
        $entityManager->flush();
    }

    public function persistEntity(EntityInterface & $entity)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);
    }

    public function flush()
    {
        $entityManager = $this->getEntityManager();
        $entityManager->flush();
    }
}
