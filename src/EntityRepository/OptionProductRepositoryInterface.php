<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method OptionProduct findOneById(UuidInterface $id)
 */
interface OptionProductRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface[] $optionValueIds
     * @param Pagination $pagination
     * @return OptionProduct[]
     */
    public function getAllOptionProductsByIds($optionValueIds, Pagination & $pagination = null);
}
