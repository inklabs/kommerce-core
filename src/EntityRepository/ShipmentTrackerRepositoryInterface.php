<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method ShipmentTracker findOneById(UuidInterface $id)
 */
interface ShipmentTrackerRepositoryInterface extends RepositoryInterface
{
    public function getAllAdHocShipments($queryString = null, Pagination & $pagination = null);
}
