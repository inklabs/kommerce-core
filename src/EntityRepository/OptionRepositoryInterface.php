<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Pagination;

/**
 * @method Option findOneById(UuidInterface $id)
 */
interface OptionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int[] $optionIds
     * @param Pagination $pagination
     * @return Option[]
     */
    public function getAllOptionsByIds(array $optionIds, Pagination & $pagination = null);

    /**
     * @param string $queryString
     * @param Pagination $pagination
     * @return Option[]
     */
    public function getAllOptions($queryString, Pagination & $pagination = null);
}
