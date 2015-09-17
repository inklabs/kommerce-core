<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OptionRepositoryInterface
{
    public function save(Entity\Option & $option);
    public function create(Entity\Option & $option);
    public function remove(Entity\Option & $option);

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
}
