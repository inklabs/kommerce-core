<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Entity\Warehouse;

class WarehouseRepository extends AbstractRepository implements WarehouseRepositoryInterface
{
    public function findByPoint(Point $point, $rangeInMiles = 50, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('Warehouse')
            ->from(Warehouse::class, 'Warehouse')
            ->withDistance($point)
            ->withinRange($point, $rangeInMiles, 'Warehouse.address.')
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
