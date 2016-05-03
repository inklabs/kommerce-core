<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\OptionValue;

/**
 * @method OptionValue findOneById($id)
 */
interface OptionValueRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int[] $optionValueIds
     * @param Pagination $pagination
     * @return OptionValue[]
     */
    public function getAllOptionValuesByIds(array $optionValueIds, Pagination & $pagination = null);
}
