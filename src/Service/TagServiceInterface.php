<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;

interface TagServiceInterface
{
    public function create(Tag & $tag);

    public function edit(Tag & $tag);

    /**
     * @param int $tagId
     */
    public function remove($tagId);

    /**
     * @param int $id
     * @return Tag
     * @throws EntityNotFoundException
     */
    public function findOneById($id);

    /**
     * @param string $code
     * @return Tag
     * @throws EntityNotFoundException
     */
    public function findOneByCode($code);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getAllTags($queryString = null, Pagination & $pagination = null);

    /**
     * @param int[] $tagIds
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getTagsByIds($tagIds, Pagination & $pagination = null);

    public function getAllTagsByIds($tagIds, Pagination & $pagination = null);
}
