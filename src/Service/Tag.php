<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class Tag extends \inklabs\kommerce\Lib\EntityManager
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
