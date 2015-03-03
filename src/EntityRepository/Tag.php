<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Entity as Entity;

class Tag extends EntityRepository
{
    /**
     * @return Entity\View\Tag[]
     */
    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $tags = $qb->select('tag')
            ->from('kommerce:tag', 'tag');

        if ($queryString !== null) {
            $tags = $tags
                ->where('tag.name LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        $tags = $tags
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $tags;
    }
}
