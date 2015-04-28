<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface WarehouseInterface
{
    /**
     * @param Entity\Point $point
     * @param int $rangeInMiles
     * @param Entity\Pagination $pagination
     * @return Entity\Warehouse
     */
    public function findByPoint(Entity\Point $point, $rangeInMiles = 50, Entity\Pagination & $pagination = null);
}
