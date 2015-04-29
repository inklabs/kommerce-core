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

    /**
     * @param Entity\OptionProduct $optionProduct
     */
    public function create(Entity\OptionProduct & $optionProduct);

    /**
     * @param Entity\OptionProduct $optionProduct
     */
    public function save(Entity\OptionProduct & $optionProduct);

    /**
     * @param Entity\OptionProduct $optionProduct
     */
    public function persist(Entity\OptionProduct & $optionProduct);

    public function flush();
}
