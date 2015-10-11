<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    public function findOneByCode($code)
    {
        return $this->returnOrThrowNotFoundException(
            parent::findOneBy(['code' => $code])
        );
    }

    public function getAllTags($queryString = null, Pagination & $pagination = null)
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

    public function getTagsByIds($tagIds, Pagination & $pagination = null)
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

    public function getAllTagsByIds($tagIds, Pagination & $pagination = null)
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
