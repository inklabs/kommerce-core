<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface TagInterface
{
    public function save(Entity\Tag & $tag);
    public function create(Entity\Tag & $tag);
    public function remove(Entity\Tag & $tag);

    /**
     * @param int $id
     * @return Entity\Tag
     */
    public function find($id);

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return Entity\Order
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return Entity\Tag[]
     */
    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null);

    /**
     * @param int []
     * @param Entity\Pagination $pagination
     * @return Entity\Tag[]
     */
    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null);

    /**
     * @param int []
     * @param Entity\Pagination $pagination
     * @return Entity\Tag[]
     */
    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null);
}
