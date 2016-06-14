<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;

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
        $query = $this->getQueryBuilder()
            ->select('Tag')
            ->from(Tag::class, 'Tag');

        if (trim($queryString) !== '') {
            $query
                ->orWhere('Tag.name LIKE :query')
                ->orWhere('Tag.code LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getTagsByIds($tagIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('Tag')
            ->from(Tag::class, 'Tag')
            ->where('Tag.id IN (:tagIds)')
            ->tagActiveAndVisible()
            ->setIdParameter('tagIds', $tagIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getAllTagsByIds($tagIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('Tag')
            ->from(Tag::class, 'Tag')
            ->where('Tag.id IN (:tagIds)')
            ->setIdParameter('tagIds', $tagIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
