<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OptionValueInterface
{
    public function save(Entity\OptionValue & $optionValue);
    public function create(Entity\OptionValue & $optionValue);
    public function remove(Entity\OptionValue & $optionValue);

    /**
     * @param int $id
     * @return Entity\OptionValue
     */
    public function find($id);

    /**
     * @param int[] $optionValueIds
     * @param Entity\Pagination $pagination
     * @return Entity\OptionValue[]
     */
    public function getAllOptionValuesByIds($optionValueIds, Entity\Pagination &$pagination = null);
}
