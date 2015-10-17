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

        if (trim($queryString) !== '') {
            $tags
                ->orWhere('tag.name LIKE :query')
                ->orWhere('tag.code LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $tags
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getTagsByIds($tagIds, Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        return $qb->select('tag')
            ->from('kommerce:Tag', 'tag')
            ->where('tag.id IN (:tagIds)')
            ->tagActiveAndVisible()
            ->setParameter('tagIds', $tagIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getAllTagsByIds($tagIds, Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        return $qb->select('tag')
            ->from('kommerce:Tag', 'tag')
            ->where('tag.id IN (:tagIds)')
            ->setParameter('tagIds', $tagIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
