<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\OptionValue;

/**
 * @method OptionValue find($id)
 */
interface OptionValueRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param int[] $optionValueIds
     * @param Pagination $pagination
     * @return \inklabs\kommerce\Entity\OptionValue[]
     */
    public function getAllOptionValuesByIds(array $optionValueIds, Pagination & $pagination = null);
}
