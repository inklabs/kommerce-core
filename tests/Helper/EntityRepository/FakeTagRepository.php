<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

class FakeTagRepository extends AbstractFakeRepository implements TagRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Tag);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getReturnValue();
    }

    public function getAllTags($queryString = null, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getTagsByIds($tagIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllTagsByIds($tagIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function create(Tag & $tag)
    {
    }

    public function save(Tag & $tag)
    {
        $tag->setUpdated();
    }

    public function remove(Tag & $tag)
    {
    }
}
