<?php
namespace inklabs\kommerce\Service;

class Tag extends EntityManager
{
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    public function find($id)
    {
        $tag = $this->entityManager->getRepository('inklabs\kommerce\Entity\Tag')->find($id);

        return $tag;
    }
}
