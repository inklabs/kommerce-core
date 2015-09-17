<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Entity\Warehouse;

class WarehouseRepository extends AbstractRepository implements WarehouseRepositoryInterface
{
    public function save(Warehouse & $warehouse)
    {
        $this->saveEntity($warehouse);
    }

    public function create(Warehouse & $warehouse)
    {
        $this->createEntity($warehouse);
    }

    public function remove(Warehouse & $warehouse)
    {
        $this->removeEntity($warehouse);
    }

    public function findByPoint(Point $point, $rangeInMiles = 50, Pagination & $pagination = null)
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
