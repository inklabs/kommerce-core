<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use LogicException;

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
     * @return Tag|null
     */
    public function findById($id);

    /**
     * @param string $code
     * @return Tag|null
     */
    public function findOneByCode($code);

    /**
     * @param int $id
     * @return Tag|null
     */
    public function findSimple($id);

    /**
     * @param int $tagId
     * @return Tag
     * @throws LogicException
     */
    public function getTagAndThrowExceptionIfMissing($tagId);

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
