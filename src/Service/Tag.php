<?php
namespace inklabs\kommerce\Service;

class Tag extends EntityManager
{
    use Common;

    public function find($id)
    {
        $tag = $this->entityManager->getRepository('inklabs\kommerce\Entity\Tag')->find($id);

        return $tag;
    }
}
