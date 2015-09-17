<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface WarehouseRepositoryInterface
{
    public function save(Entity\Warehouse & $warehouse);
    public function create(Entity\Warehouse & $warehouse);
    public function remove(Entity\Warehouse & $warehouse);

    /**
     * @param int $id
     * @return Entity\Warehouse
     */
    public function find($id);

    /**
     * @param Entity\Point $point
     * @param int $rangeInMiles
     * @param Entity\Pagination $pagination
     * @return Entity\Warehouse[]
     */
    public function findByPoint(Entity\Point $point, $rangeInMiles = 50, Entity\Pagination & $pagination = null);
}
