<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OptionProductInterface
{
    /**
     * @param int $id
     * @return Entity\OptionProduct
     */
    public function find($id);

    /**
     * @param int[] $optionValueIds
     * @param Entity\Pagination $pagination
     * @return Entity\OptionProduct[]
     */
    public function getAllOptionProductsByIds($optionValueIds, Entity\Pagination &$pagination = null);
}
