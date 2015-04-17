<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

/**
 * @method Entity\Warehouse find($id)
 */
class Warehouse extends AbstractEntityRepository
{
    /**
     * @return array
     */
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
