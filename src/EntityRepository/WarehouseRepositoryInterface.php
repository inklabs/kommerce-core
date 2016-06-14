<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Warehouse findOneById(UuidInterface $id)
 */
interface WarehouseRepositoryInterface extends RepositoryInterface
{
    /**
     * @param Point $point
     * @param int $rangeInMiles
     * @param Pagination $pagination
     * @return Warehouse[]
     */
    public function findByPoint(Point $point, $rangeInMiles = 50, Pagination & $pagination = null);
}
