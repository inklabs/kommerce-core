<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

interface TagServiceInterface
{
    public function update(Tag & $tag);

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

    public function getAllTagsByIds($tagIds, Pagination & $pagination = null);
}
