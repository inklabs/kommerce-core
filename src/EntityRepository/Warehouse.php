<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class Warehouse extends AbstractEntityRepository implements WarehouseInterface
{
    public function save(Entity\Warehouse & $warehouse)
    {
        $this->saveEntity($warehouse);
    }

    public function create(Entity\Warehouse & $warehouse)
    {
        $this->createEntity($warehouse);
    }

    public function remove(Entity\Warehouse & $warehouse)
    {
        $this->removeEntity($warehouse);
    }

    public function findByPoint(Entity\Point $point, $rangeInMiles = 50, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $warehouses = $qb
            ->select('warehouse')
            ->from('kommerce:Warehouse', 'warehouse')
            ->withDistance($point)
            ->withinRange($point, $rangeInMiles, 'warehouse.address.')
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $warehouses;
    }
}
