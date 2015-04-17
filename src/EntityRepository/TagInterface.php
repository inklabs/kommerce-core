<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface TagInterface
{
    /**
     * @param string $queryString
     * @method Entity\Tag find($id)
     */
    public function find($id);

    /**
     * @param string $queryString
     * @return Entity\Tag[]
     */
    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null);

    /**
     * @param int[]
     * @return Entity\Tag[]
     */
    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null);

    /**
     * @param int[]
     * @return Entity\Tag[]
     */
    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null);
}
