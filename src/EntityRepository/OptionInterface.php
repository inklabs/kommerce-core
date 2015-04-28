<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OptionInterface
{
    /**
     * @param int[] $optionIds
     * @param Entity\Pagination $pagination
     * @return Option[]
     */
    public function getAllOptionsByIds($optionIds, Entity\Pagination &$pagination = null);
}
