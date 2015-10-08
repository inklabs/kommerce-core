<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;

/**
 * @method Tag find($id)
 */
interface TagRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $code
     * @return Tag
     */
    public function findOneByCode($code);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getAllTags($queryString = null, Pagination & $pagination = null);

    /**
     * @param int []
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getTagsByIds($tagIds, Pagination & $pagination = null);

    /**
     * @param int []
     * @param Pagination $pagination
     * @return Tag[]
     */
    public function getAllTagsByIds($tagIds, Pagination & $pagination = null);
}
