<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OptionInterface
{
    /**
     * @param int $id
     * @return Entity\Option
     */
    public function find($id);

    /**
     * @param int[] $optionIds
     * @param Entity\Pagination $pagination
     * @return Entity\Option[]
     */
    public function getAllOptionsByIds($optionIds, Entity\Pagination &$pagination = null);
}
