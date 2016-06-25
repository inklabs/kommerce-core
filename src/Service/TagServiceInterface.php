<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface TagServiceInterface
{
    public function create(Tag & $tag);
    public function update(Tag & $tag);

    /**
     * @param Tag $tag
     */
    public function delete(Tag $tag);

    /**
     * @param UuidInterface $tagId
     * @param UuidInterface $imageId
     * @throws EntityNotFoundException
     */
    public function removeImage(UuidInterface $tagId, UuidInterface $imageId);

    /**
     * @param UuidInterface $tagId
     * @param UuidInterface $optionId
     * @throws EntityNotFoundException
     */
    public function addOption(UuidInterface $tagId, UuidInterface $optionId);

    /**
     * @param UuidInterface $tagId
     * @param UuidInterface $optionId
     * @throws EntityNotFoundException
     */
    public function removeOption(UuidInterface $tagId, UuidInterface $optionId);

    /**
     * @param UuidInterface $id
     * @return Tag
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id);

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
     * @param UuidInterface[] $tagIds
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getTagsByIds($tagIds, Pagination & $pagination = null);

    public function getAllTagsByIds($tagIds, Pagination & $pagination = null);
}
