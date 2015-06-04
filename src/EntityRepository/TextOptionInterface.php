<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface TextOptionInterface
{
    public function save(Entity\TextOption & $textOption);
    public function create(Entity\TextOption & $textOption);
    public function remove(Entity\TextOption & $textOption);

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
