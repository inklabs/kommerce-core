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
     * @param Pagination|null $pagination
     * @return Warehouse[]
     */
    public function findByPoint(Point $point, int $rangeInMiles = 50, Pagination & $pagination = null);

    /**
     * @param string|null $queryString
     * @param Pagination|null $pagination
     * @return Warehouse[]
     */
    public function getAllWarehouses(string $queryString = null, Pagination & $pagination = null);
}
