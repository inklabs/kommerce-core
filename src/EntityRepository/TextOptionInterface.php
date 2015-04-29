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
     * @return Entity\TextOption[]
     */
    public function getAllTextOptionsByIds($optionIds, Entity\Pagination & $pagination = null);
}
