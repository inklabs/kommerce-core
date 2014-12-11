<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Lib as Lib;

class EntityManager
{
    /* @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByEncodedId($encodedId)
    {
        return $this->find(Lib\BaseConvert::decode($encodedId));
    }
}
