<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface TextOptionInterface
{
    /**
     * @param int $id
     * @return Entity\TextOption
     */
    public function find($id);

    /**
     * @param int[] $optionIds
     * @param Entity\Pagination $pagination
     * @return TextOption[]
     */
    public function getAllOptionsByIds($optionIds, Entity\Pagination & $pagination = null);
}
