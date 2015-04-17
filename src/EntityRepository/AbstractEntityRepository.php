<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\QueryBuilder;
use inklabs\kommerce\Entity\EntityInterface;

abstract class AbstractEntityRepository extends \Doctrine\ORM\EntityRepository
{
    public function getQueryBuilder()
    {
        return new QueryBuilder($this->getEntityManager());
    }

    public function save(EntityInterface & $entity)
    {
        $entityManager = $this->getEntityManager();
        $entity = $entityManager->merge($entity);
        $entityManager->flush();
    }
}
