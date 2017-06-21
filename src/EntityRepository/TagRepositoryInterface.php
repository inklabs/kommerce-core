<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Tag findOneById(UuidInterface $id)
 */
interface TagRepositoryInterface extends RepositoryInterface
{
    public function findOneByCode(string $code): Tag;

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getAllTags(string $queryString = null, Pagination & $pagination = null);

    /**
     * @param UuidInterface[]
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getTagsByIds(array $tagIds, Pagination & $pagination = null);

    /**
     * @param UuidInterface[]
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getAllTagsByIds(array $tagIds, Pagination & $pagination = null);
}
