<?php
namespace inklabs\kommerce\Service;

class EntityManager
{
    protected $entityManager;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
