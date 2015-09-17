<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    public function save(Entity\Tag & $tag)
    {
        $this->saveEntity($tag);
    }

    public function create(Entity\Tag & $tag)
    {
        $this->createEntity($tag);
    }

    public function remove(Entity\Tag & $tag)
    {
        $this->removeEntity($tag);
    }

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
