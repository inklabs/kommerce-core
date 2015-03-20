<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Entity as Entity;

/**
 * @method Entity\Tag find($id)
 */
class Tag extends EntityRepository
{
    /**
     * @return Entity\Tag[]
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

    /**
     * @return Entity\Tag[]
     */
    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $tags = $qb->select('tag')
            ->from('kommerce:Tag', 'tag')
            ->where('tag.id IN (:tagIds)')
            ->tagActiveAndVisible()
            ->setParameter('tagIds', $tagIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $tags;
    }

    /**
     * @return Entity\Tag[]
     */
    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $tags = $qb->select('tag')
            ->from('kommerce:Tag', 'tag')
            ->where('tag.id IN (:tagIds)')
            ->setParameter('tagIds', $tagIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $tags;
    }
}
