<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Pagination;

/**
 * @method OptionProduct find($id)
 */
interface OptionProductRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param int[] $optionValueIds
     * @param Pagination $pagination
     * @return OptionProduct[]
     */
    public function getAllOptionProductsByIds($optionValueIds, Pagination & $pagination = null);
}
