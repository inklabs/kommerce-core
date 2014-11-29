<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Doctrine\ORM\QueryBuilder;

class EntityManager
{
    /* @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createQueryBuilder()
    {
        return new QueryBuilder($this->entityManager);
    }

    public function findByEncodedId($encodedId)
    {
        $id = BaseConvert::decode($encodedId);
        return $this->find($id);
    }
}
