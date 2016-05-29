<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

/**
 * @method Tag findOneById(UuidInterface $id)
 */
interface TagRepositoryInterface extends RepositoryInterface
{
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
     * @param UuidInterface[]
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getTagsByIds($tagIds, Pagination & $pagination = null);

    /**
     * @param UuidInterface[]
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getAllTagsByIds($tagIds, Pagination & $pagination = null);
}
