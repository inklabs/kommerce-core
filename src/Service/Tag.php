<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Tag extends Lib\EntityManager
{
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    public function find($id)
    {
        $tag = $this->entityManager->getRepository('inklabs\kommerce\Entity\Tag')->find($id);

        return Entity\View\Tag::factory($tag)
            ->export();
    }
}
