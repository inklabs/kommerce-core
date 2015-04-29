<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Lib;
use inklabs\kommerce\Doctrine\ORM\QueryBuilder;
use inklabs\kommerce\Entity\EntityInterface;

abstract class AbstractEntityRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByEncodedId($encodedId)
    {
        return $this->find(Lib\BaseConvert::decode($encodedId));
    }

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

    public function persistEntity(EntityInterface & $entity)
    {
        $this->getEntityManager()->persist($entity);
    }

    public function flush()
    {
        $this->getEntityManager()->flush();
    }
}
