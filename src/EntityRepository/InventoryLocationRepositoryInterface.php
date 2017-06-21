<?php
namespace inklabs\kommerce\EntityRepository;

use Generator;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\ProductStock;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method InventoryLocation findOneById(UuidInterface $id)
 */
interface InventoryLocationRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface $inventoryLocationId
     * @param Pagination $pagination
     * @return Generator|ProductStock[]
     */
    public function listProductStockForInventoryLocation(
        UuidInterface $inventoryLocationId,
        Pagination & $pagination
    ): Generator;
}
