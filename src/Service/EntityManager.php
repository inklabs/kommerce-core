<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Doctrine\ORM\QueryBuilder;

class EntityManager
{
    protected $entityManager;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
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
