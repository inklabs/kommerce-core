<?php
namespace inklabs\kommerce\Lib;

class EntityManager
{
    /* @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
