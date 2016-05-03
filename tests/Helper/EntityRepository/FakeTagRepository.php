<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

/**
 * @method Tag findOneById($id)
 */
class FakeTagRepository extends FakeRepository implements TagRepositoryInterface
{
    protected $entityName = 'Tag';

    public function __construct()
    {
        $this->setReturnValue(new Tag);
    }

    public function findOneByCode($code)
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
}
