<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OptionProductRepositoryInterface
{
    public function save(Entity\OptionProduct & $optionProduct);
    public function create(Entity\OptionProduct & $optionProduct);
    public function remove(Entity\OptionProduct & $optionProduct);

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
