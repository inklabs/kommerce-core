<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Entity\Warehouse;

/**
 * @method Warehouse find($id)
 */
interface WarehouseRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param Point $point
     * @param int $rangeInMiles
     * @param Pagination $pagination
     * @return Warehouse[]
     */
    public function findByPoint(Point $point, $rangeInMiles = 50, Pagination & $pagination = null);
}
