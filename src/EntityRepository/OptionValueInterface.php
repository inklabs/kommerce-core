<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OptionValueInterface
{
    /**
     * @param int $id
     * @return Entity\OptionValue
     */
    public function find($id);

    /**
     * @param $optionValueIds
     * @param Entity\Pagination $pagination
     * @return Entity\OptionValue[]
     */
    public function getAllOptionValuesByIds($optionValueIds, Entity\Pagination &$pagination = null);
}
