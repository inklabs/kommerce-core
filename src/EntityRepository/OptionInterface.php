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
    public function getAllOptionsByIds(array $optionIds, Entity\Pagination & $pagination = null);

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return Entity\Option[]
     */
    public function getAllOptions($queryString, Entity\Pagination & $pagination = null);

    /**
     * @param Entity\Option $option
     */
    public function create(Entity\Option & $option);

    /**
     * @param Entity\Option $option
     */
    public function save(Entity\Option & $option);

    /**
     * @param Entity\Option $option
     */
    public function persist(Entity\Option & $option);

    public function flush();
}
