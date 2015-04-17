<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\TagInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class FakeTag extends Helper\AbstractFake implements TagInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Tag);
    }

    /**
     * @method Entity\Product find($id)
     */
    public function find($id)
    {
        return $this->getReturnValue();
    }

    /**
     * @param string $queryString
     * @return Entity\Tag[]
     */
    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    /**
     * @param int[]
     * @return Entity\Tag[]
     */
    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    /**
     * @param int[]
     * @return Entity\Tag[]
     */
    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
