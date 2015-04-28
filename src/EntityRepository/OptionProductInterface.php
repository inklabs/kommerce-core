<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OptionProductInterface
{
    /**
     * @param int $id
     * @return OptionProduct
     */
    public function find($id);

    /**
     * @param int[] $optionValueIds
     * @param Entity\Pagination $pagination
     * @return OptionProduct[]
     */
    public function getAllOptionProductsByIds($optionValueIds, Entity\Pagination &$pagination = null);
}
