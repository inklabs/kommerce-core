<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Pagination;

/**
 * @method OptionProduct findOneById($id)
 */
interface OptionProductRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int[] $optionValueIds
     * @param Pagination $pagination
     * @return OptionProduct[]
     */
    public function getAllOptionProductsByIds($optionValueIds, Pagination & $pagination = null);
}
